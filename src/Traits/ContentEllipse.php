<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Traits;

trait ContentEllipse
{

    public function getShortContent($maxlength = 50, $attr = 'content')
    {
        $content = $this->{$attr};
        if (strlen($content) > $maxlength) {
            return substr($content, 0, $maxlength).'...';
        }

        return $content;
    }
}
