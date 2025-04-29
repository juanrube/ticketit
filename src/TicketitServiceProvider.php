<?php



namespace Juanrube\Ticketit;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Juanrube\Ticketit\Console\Htmlify;
use Juanrube\Ticketit\Controllers\InstallController;
use Juanrube\Ticketit\Controllers\NotificationsController;
use Juanrube\Ticketit\Models\Comment;
use Juanrube\Ticketit\Models\Setting;
use Juanrube\Ticketit\Models\Ticket;
use Juanrube\Ticketit\ViewComposers\TicketItComposer;
use Spatie\Html\Facades\Html; // Reemplazamos Collective por Spatie

class TicketitServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (! Schema::hasTable('migrations')) {
            // Database isn't installed yet.
            return;
        }
        $installer = new InstallController;

        // if a migration or new setting is missing scape to the installation
        if (empty($installer->inactiveMigrations()) && ! $installer->inactiveSettings()) {
            // Send the Agent User model to the view under $u
            // Send settings to views under $setting

            // cache $u
            $u = null;

            TicketItComposer::settings($u);

            // Reemplazamos el macro de Collective por Spatie
            Html::macro('custom', function ($type, $name, $value = '#000000', $options = []) {
                return Html::input($type, $name, $value, $options);
            });

            TicketItComposer::general();
            TicketItComposer::codeMirror();
            TicketItComposer::sharedAssets();
            TicketItComposer::summerNotes();

            // Send notification when new comment is added
            Comment::creating(function ($comment) {
                if (Setting::grab('comment_notification')) {
                    $notification = new NotificationsController;
                    $notification->newComment($comment);
                }
            });

            // Send notification when ticket status is modified
            Ticket::updating(function ($modified_ticket) {
                if (Setting::grab('status_notification')) {
                    $original_ticket = Ticket::find($modified_ticket->id);
                    if ($original_ticket->status_id != $modified_ticket->status_id || $original_ticket->completed_at != $modified_ticket->completed_at) {
                        $notification = new NotificationsController;
                        $notification->ticketStatusUpdated($modified_ticket, $original_ticket);
                    }
                }
                if (Setting::grab('assigned_notification')) {
                    $original_ticket = Ticket::find($modified_ticket->id);
                    if ($original_ticket->agent->id != $modified_ticket->agent->id) {
                        $notification = new NotificationsController;
                        $notification->ticketAgentUpdated($modified_ticket, $original_ticket);
                    }
                }

                return true;
            });

            // Send notification when ticket status is modified
            Ticket::created(function ($ticket) {
                if (Setting::grab('assigned_notification')) {
                    $notification = new NotificationsController;
                    $notification->newTicketNotifyAgent($ticket);
                }

                return true;
            });

            $this->loadTranslationsFrom(__DIR__ . '/Translations', 'ticketit');

            $viewsDirectory = __DIR__ . '/Views/bootstrap5';

            $this->loadViewsFrom($viewsDirectory, 'ticketit');

            $this->publishes([$viewsDirectory => base_path('resources/views/vendor/ticketit')], 'views');
            $this->publishes([__DIR__ . '/Translations' => base_path('resources/lang/vendor/ticketit')], 'lang');
            $this->publishes([__DIR__ . '/Public' => public_path('vendor/ticketit')], 'public');
            $this->publishes([__DIR__ . '/Migrations' => base_path('database/migrations')], 'db');

            $main_route = Setting::grab('main_route');
            $main_route_path = Setting::grab('main_route_path');
            $admin_route = Setting::grab('admin_route');
            $admin_route_path = Setting::grab('admin_route_path');

            if (file_exists(Setting::grab('routes'))) {
                include Setting::grab('routes');
            } else {
                include __DIR__ . '/routes.php';
            }
        } elseif (
            Request::path() == 'tickets-install'
            || Request::path() == 'tickets-upgrade'
            || Request::path() == 'tickets'
            || Request::path() == 'tickets-admin'
            || (isset($_SERVER['ARTISAN_TICKETIT_INSTALLING']) && $_SERVER['ARTISAN_TICKETIT_INSTALLING'])
        ) {
            $this->loadTranslationsFrom(__DIR__ . '/Translations', 'ticketit');
            $this->loadViewsFrom(__DIR__ . '/Views/bootstrap5', 'ticketit');
            $this->publishes([__DIR__ . '/Migrations' => base_path('database/migrations')], 'db');

            $authMiddleware = Helpers\LaravelVersion::authMiddleware();

            Route::get('/tickets-install', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.index',
                'uses' => 'Juanrube\Ticketit\Controllers\InstallController@index',
            ]);
            Route::post('/tickets-install', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.setup',
                'uses' => 'Juanrube\Ticketit\Controllers\InstallController@setup',
            ]);
            Route::get('/tickets-upgrade', [
                'middleware' => $authMiddleware,
                'as' => 'tickets.install.upgrade',
                'uses' => 'Juanrube\Ticketit\Controllers\InstallController@upgrade',
            ]);
            Route::get('/tickets', function () {
                return redirect()->route('tickets.install.index');
            });
            Route::get('/tickets-admin', function () {
                return redirect()->route('tickets.install.index');
            });
        }
    }

    public function register()
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register(\Spatie\Html\HtmlServiceProvider::class); // Reemplazamos Collective por Spatie

        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);

        $this->app->register(\Mews\Purifier\PurifierServiceProvider::class);

        /*
         * Register htmlify command. Need to run this when upgrading from <=0.2.2
         */

        $this->app->singleton('command.juanrube.ticketit.htmlify', function ($app) {
            return new Htmlify;
        });
        $this->commands('command.juanrube.ticketit.htmlify');
    }
}
