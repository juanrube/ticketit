@if($editor_enabled)
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@if($codemirror_enabled)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{Juanrube\Ticketit\Helpers\Cdn::CodeMirror}}/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{Juanrube\Ticketit\Helpers\Cdn::CodeMirror}}/mode/xml/xml.min.js"></script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/{{Juanrube\Ticketit\Helpers\Cdn::Summernote}}/summernote-bs5.min.js"></script>
@if($editor_locale)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/{{Juanrube\Ticketit\Helpers\Cdn::Summernote}}/lang/summernote-{{$editor_locale}}.min.js"></script>
@endif
<script>
    $(function() {

        var options = $.extend(true, {lang: '{{$editor_locale}}' {!! $codemirror_enabled ? ", codemirror: {theme: '{$codemirror_theme}', mode: 'text/html', htmlMode: true, lineWrapping: true}" : ''  !!} } , {!! $editor_options !!});

        $("textarea.summernote-editor").summernote(options);

        $("label[for=content]").click(function () {
            $("#content").summernote("focus");
        });
    });
</script>
@endif