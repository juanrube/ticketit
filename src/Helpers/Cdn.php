<?php



namespace Juanrube\Ticketit\Helpers;

class Cdn
{
    const CodeMirror = '6.65.7';

    const Summernote = '0.9.1';

    const FontAwesome = '4.7.0';

    const FontAwesome5 = '5.10.1';

    // https://datatables.net/download/
    const DataTables = '1.10.18';

    const DataTablesResponsive = '2.2.2';

    public static function asset($asset)
    {
        return vite($asset, true);
    }
}
