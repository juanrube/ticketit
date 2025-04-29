<?php



namespace Juanrube\Ticketit\Traits;

use Juanrube\Ticketit\Models\Setting;
use Mews\Purifier\Facades\Purifier;

trait Purifiable
{

    public function setPurifiedContent($rawHtml)
    {
        $this->content = Purifier::clean($rawHtml, ['HTML.Allowed' => '']);
        $this->html = Purifier::clean($rawHtml, Setting::grab('purifier_config'));

        return $this;
    }
}
