{{-- Load the css file to the header --}}
<script type="text/javascript">
    function loadCSS(filename) {
        var file = document.createElement("link");
        file.setAttribute("rel", "stylesheet");
        file.setAttribute("type", "text/css");
        file.setAttribute("href", filename);

        if (typeof file !== "undefined") {
            document.getElementsByTagName("head")[0].appendChild(file);
        }
    }
    loadCSS("{!! asset('https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.2/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/date-1.5.5/r-3.0.4/sp-2.3.3/datatables.min.css') !!}");
    @if($editor_enabled)
        loadCSS("{!! asset('https://cdnjs.cloudflare.com/ajax/libs/summernote/' . Juanrube\Ticketit\Helpers\Cdn::Summernote . '/summernote-bs4.css') !!}");
        @if($include_font_awesome)
            loadCSS("{!! asset('https://use.fontawesome.com/releases/v' . Juanrube\Ticketit\Helpers\Cdn::FontAwesome5 . '/css/solid.css') !!}");
            loadCSS("{!! asset('https://use.fontawesome.com/releases/v' . Juanrube\Ticketit\Helpers\Cdn::FontAwesome5 . '/css/fontawesome.css') !!}");
        @endif
        @if($codemirror_enabled)
            loadCSS("{!! asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . Juanrube\Ticketit\Helpers\Cdn::CodeMirror . '/codemirror.min.css') !!}");
            loadCSS("{!! asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . Juanrube\Ticketit\Helpers\Cdn::CodeMirror . '/theme/' . $codemirror_theme . '.min.css') !!}");
        @endif
    @endif
</script>