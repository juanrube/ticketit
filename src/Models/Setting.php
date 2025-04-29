<?php



namespace Juanrube\Ticketit\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Juanrube\Ticketit\Helpers\LaravelVersion;
use Juanrube\Ticketit\Models\Setting as Table;

class Setting extends Model
{

    protected $fillable = ['lang', 'slug', 'value', 'default'];

    protected $table = 'ticketit_settings';

    public function scopeBySlug($query, $slug)
    {
        return $query->whereSlug($slug);
    }

    public static function grab($slug)
    {
        /*
         * Comment out prior to 0.2 launch. Will cause massive amount
         * of Database queries. Only for adding new settings while
         * in development and testing.
         */
        $time = 60 * 60;

        $setting = Cache::remember('ticketit::settings.'.$slug, $time, function () use ($slug, $time) {
            $settings = Cache::remember('ticketit::settings', $time, function () {
                return Table::all();
            });

            $setting = $settings->where('slug', $slug)->first();

            if ($setting->lang) {
                return trans($setting->lang);
            }

            if (self::is_serialized($setting->value)) {
                $setting = unserialize($setting->value);
            } else {
                $setting = $setting->value;
            }

            return $setting;
        });

        return $setting;
    }

    public static function is_serialized($data, $strict = true)
    {
        // if it isn't a string, it isn't serialized.
        if (! is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ($data == 'N;') {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if ($data[1] !== ':') {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if ($lastc !== ';' && $lastc !== '}') {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            // Either ; or } must exist.
            if ($semicolon === false && $brace === false) {
                return false;
            }

            // But neither must be in the first X characters.
            if ($semicolon !== false && $semicolon < 3) {
                return false;
            }

            if ($brace !== false && $brace < 4) {
                return false;
            }
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($strict) {
                    if (substr($data, -2, 1) !== '"') {
                        return false;
                    }
                } elseif (!str_contains($data, '"')) {
                    return false;
                }
                // or else fall through
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';

                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }
}
