<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Helpers;

use Illuminate\Routing\Router;

class LaravelVersion
{

    public static function getLaravelVersion()
    {
        $laravel = app();

        return $laravel::VERSION;
    }

    public static function compare($operator, $version)
    {
        return version_compare(static::getLaravelVersion(), $version, $operator);
    }

    public static function lt($version)
    {
        return static::compare('<', $version);
    }

    public static function gt($version)
    {
        return static::compare('>', $version);
    }

    public static function min($version)
    {
        return static::compare('>=', $version);
    }

    public static function max($version)
    {
        return static::compare('<=', $version);
    }

    public static function authMiddleware()
    {
        if (static::min('5.2') && static::lt('5.3') && app(Router::class)->resolveMiddlewareClassName('web') != 'web') {
            return ['web', 'auth'];
        } elseif (static::min('5.3')) {
            return ['web', 'auth'];
        }

        return ['auth'];
    }
}
