<?php

namespace Juanrube\Ticketit\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Juanrube\Ticketit\Models\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Juanrube\Ticketit\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Juanrube\Ticketit\Seeds\SettingsTableSeeder;
use Juanrube\Ticketit\Seeds\TicketitTableSeeder;

class InstallController extends Controller
{
    public $migrations_tables = [];

    public function __construct()
    {
        $migrations = File::files(dirname(dirname(__FILE__)) . '/Migrations');
        foreach ($migrations as $migration) {
            $this->migrations_tables[] = basename($migration, '.php');
        }
    }

    public function publicAssets()
    {
        $public = $this->allFilesList(public_path('vendor/ticketit'));
        $assets = $this->allFilesList(base_path('vendor/juanrube/ticketit/src/Public'));
        if ($public !== $assets) {
            Artisan::call('vendor:publish', [
                '--provider' => 'Juanrube\\Ticketit\\TicketitServiceProvider',
                '--tag' => ['public'],
            ]);
        }
    }

    /*
     * Initial install form
     */

    public function index()
    {
        // if all migrations are not yet installed or missing settings table,
        // then start the initial install with admin and master template choices
        if (
            count($this->migrations_tables) == count($this->inactiveMigrations())
            || in_array('2015_10_08_123457_create_settings_table', $this->inactiveMigrations())
        ) {
            $views_files_list = $this->viewsFilesList(resource_path('views')) + ['another' => trans('ticketit::install.another-file')];
            $inactive_migrations = $this->inactiveMigrations();

            $users_list = User::pluck('name', 'id')->toArray();

            return view('ticketit::install.index', compact('views_files_list', 'inactive_migrations', 'users_list'));
        }

        // other than that, Upgrade to a new version, installing new migrations and new settings slugs
        if (Agent::isAdmin()) {
            $inactive_migrations = $this->inactiveMigrations();
            $inactive_settings = $this->inactiveSettings();

            return view('ticketit::install.upgrade', compact('inactive_migrations', 'inactive_settings'));
        }
        Log::emergency('Ticketit needs upgrade, admin should login and visit ticketit-install to activate the upgrade');

        throw new \Exception('Ticketit needs upgrade, admin should login and visit ticketit install route');
    }

    /*
     * Do all pre-requested setup
     */

    public function setup(Request $request)
    {
        $master = $request->master;
        if ($master == 'another') {
            $another_file = $request->other_path;
            $views_content = strstr(substr(strstr($another_file, 'views/'), 6), '.blade.php', true);
            $master = str_replace('/', '.', $views_content);
        }
        $this->initialSettings($master);
        $admin_id = $request->admin_id;
        $admin = User::find($admin_id);
        $admin->ticketit_admin = true;
        $admin->save();

        return redirect('/' . Setting::grab('main_route'));
    }

    /*
     * Do version upgrade
     */

    public function upgrade()
    {
        if (Agent::isAdmin()) {
            $this->initialSettings();

            return redirect('/' . Setting::grab('main_route'));
        }
        Log::emergency('Ticketit upgrade path access: Only admin is allowed to upgrade');

        throw new \Exception('Ticketit upgrade path access: Only admin is allowed to upgrade');
    }

    /*
     * Initial installer to install migrations, seed default settings, and configure the master_template
     */

    public function initialSettings($master = false)
    {
        $inactive_migrations = $this->inactiveMigrations();
        if ($inactive_migrations) { // If a migration is missing, do the migrate
            Artisan::call('vendor:publish', [
                '--provider' => 'Juanrube\\Ticketit\\TicketitServiceProvider',
                '--tag' => ['db'],
            ]);
            Artisan::call('migrate');

            $this->settingsSeeder($master);

            // if this is the first install of the html editor, seed old posts text to the new html column
            if (
                in_array('2016_01_15_002617_add_htmlcontent_to_ticketit_and_comments', $inactive_migrations) &&
                ! (isset($_SERVER['ARTISAN_TICKETIT_INSTALLING']) && $_SERVER['ARTISAN_TICKETIT_INSTALLING'])
            ) {
                Artisan::call('ticketit:htmlify');
            }
        } elseif ($this->inactiveSettings()) { // new settings to be installed

            $this->settingsSeeder($master);
        }
        Cache::forget('ticketit::settings');
    }

    public function settingsSeeder($master = false)
    {
        $cli_path = 'config/ticketit.php'; // if seeder run from cli, use the cli path
        $provider_path = '../config/ticketit.php'; // if seeder run from provider, use the provider path
        $config_settings = [];
        $settings_file_path = false;
        if (File::isFile($cli_path)) {
            $settings_file_path = $cli_path;
        } elseif (File::isFile($provider_path)) {
            $settings_file_path = $provider_path;
        }
        if ($settings_file_path) {
            $config_settings = include $settings_file_path;
            File::move($settings_file_path, $settings_file_path . '.backup');
        }
        $seeder = new SettingsTableSeeder;
        if ($master) {
            $config_settings['master_template'] = $master;
        }
        $seeder->config = $config_settings;
        $seeder->run();
    }

    public function viewsFilesList($dir_path)
    {
        $dir_files = File::files($dir_path);
        $files = [];
        foreach ($dir_files as $file) {
            $path = basename($file);
            $name = strstr(basename($file), '.', true);
            $files[$name] = $path;
        }

        return $files;
    }

    public function allFilesList($dir_path)
    {
        $files = [];
        if (File::exists($dir_path)) {
            $dir_files = File::allFiles($dir_path);
            foreach ($dir_files as $file) {
                $path = basename($file);
                $name = strstr(basename($file), '.', true);
                $files[$name] = $path;
            }
        }

        return $files;
    }

    public function inactiveMigrations()
    {
        $inactiveMigrations = [];
        $migration_arr = [];

        // Package Migrations
        $tables = $this->migrations_tables;

        // Application active migrations
        $migrations = DB::select('select * from ' . DB::getTablePrefix() . 'migrations');

        foreach ($migrations as $migration_parent) { // Count active package migrations
            $migration_arr[] = $migration_parent->migration;
        }

        foreach ($tables as $table) {
            if (! in_array($table, $migration_arr)) {
                $inactiveMigrations[] = $table;
            }
        }

        return $inactiveMigrations;
    }

    public function inactiveSettings()
    {
        $seeder = new SettingsTableSeeder;

        // Package Settings
        $installed_settings = DB::table('ticketit_settings')->pluck('value', 'slug');

        if (! is_array($installed_settings)) {
            $installed_settings = $installed_settings->toArray();
        }

        // Application active migrations
        $default_Settings = $seeder->getDefaults();

        if (count($installed_settings) == count($default_Settings)) {
            return false;
        }

        $inactive_settings = array_diff_key($default_Settings, $installed_settings);

        return $inactive_settings;
    }

    public function demoDataSeeder()
    {
        $seeder = new TicketitTableSeeder;
        $seeder->run();
        session()->flash('status', 'Demo tickets, users, and agents are seeded!');

        return redirect()->route(Setting::grab('main_route') . '.index');
    }
}
