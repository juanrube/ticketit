<?php

namespace Juanrube\Ticketit\Helpers;

class Cdn
{
    const CodeMirror = '5.48.4';

    const Summernote = '0.8.12';

    const FontAwesome = '4.7.0';

    const FontAwesome5 = '5.10.1';

    // https://datatables.net/download/
    const DataTables = '1.10.18';

    const DataTablesResponsive = '2.2.2';

    /**
     * Get the URL for a given asset using Vite.
     *
     * @param  string  $asset
     * @return string
     */
    public static function asset($asset)
    {
        return vite($asset, true);
    }
}
