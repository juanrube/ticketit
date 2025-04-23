<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class ToolsController extends Controller
{

    public function sortArray($data, $field, $type = 'desc')
    {
        uasort($data, function ($a, $b) use ($field, $type) {
            if ($a[$field] == $b[$field]) {
                return 0;
            }
            if ($type == 'desc') {
                return $a[$field] < $b[$field] ? 1 : -1;
            }
            if ($type == 'asc') {
                return $a[$field] > $b[$field] ? 1 : -1;
            }
        });

        return $data;
    }

    public function fullUrlIs($match)
    {
        $url = Request::fullUrl();

        if (Str::is($match, $url)) {
            return true;
        }

        return false;
    }
}
