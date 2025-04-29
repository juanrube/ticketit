@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.config-edit-subtitle'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.configuration.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left mr-2"></i>
    {{ trans('ticketit::admin.btn-back') }}
</a>
@stop

@section('ticketit_content')
    {!! Html::form()->action(route($setting->grab('admin_route').'.configuration.update', $configuration->id))->method('PATCH')->open() !!}
        <div class="card bg-light mb-3">
            <div class="card-body">
                <b>{{ trans('ticketit::admin.config-edit-tools') }}</b>
                <br>
                <a href="https://www.functions-online.com/unserialize.html" target="_blank">
                    {{ trans('ticketit::admin.config-edit-unserialize') }}
                </a>
                <br>
                <a href="https://www.functions-online.com/serialize.html" target="_blank">
                    {{ trans('ticketit::admin.config-edit-serialize') }}
                </a>
            </div>
        </div>

        @if(trans("ticketit::settings." . $configuration->slug) != ("ticketit::settings." . $configuration->slug) && trans("ticketit::settings." . $configuration->slug))
            <div class="card border-info mb-3">
                <div class="card-body">{!! trans("ticketit::settings." . $configuration->slug) !!}</div>
            </div>
        @endif

        <!-- ID Field -->
        <div class="form-group row">
            {!! Html::label('id', trans('ticketit::admin.config-edit-id') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                {!! Html::text('id', $configuration->id)->class('form-control')->disabled() !!}
            </div>
        </div>

        <!-- Slug Field -->
        <div class="form-group row">
            {!! Html::label('slug', trans('ticketit::admin.config-edit-slug') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                {!! Html::text('slug', $configuration->slug)->class('form-control')->disabled() !!}
            </div>
        </div>

        <!-- Default Field -->
        <div class="form-group row">
            {!! Html::label('default', trans('ticketit::admin.config-edit-default') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                @if(!$default_serialized)
                    {!! Html::text('default', $configuration->default)->class('form-control')->disabled() !!}
                @else
                    <pre>{{ var_export(unserialize($configuration->default), true) }}</pre>
                @endif
            </div>
        </div>

        <!-- Value Field -->
        <div class="form-group row">
            {!! Html::label('value', trans('ticketit::admin.config-edit-value') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                @if(!$should_serialize)
                    {!! Html::text('value', $configuration->value)->class('form-control') !!}
                @else
                    {!! Html::textarea('value', var_export(unserialize($configuration->value), true))->class('form-control') !!}
                @endif
            </div>
        </div>

        <!-- Serialize Field -->
        <div class="form-group row">
            {!! Html::label('serialize', trans('ticketit::admin.config-edit-should-serialize') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                {!! Html::checkbox('serialize', 1, $should_serialize)->class('form-check-input')->attribute('onchange', 'changeSerialize(this)') !!}
                <span class="form-text text-danger">@lang('ticketit::admin.config-edit-eval-warning') <code>eval('$value = serialize(' . $value . ');')</code></span>
            </div>
        </div>

        <!-- Password Field -->
        <div id="serialize-password" class="form-group row">
            {!! Html::label('password', trans('ticketit::admin.config-edit-reenter-password') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                {!! Html::password('password')->class('form-control') !!}
            </div>
        </div>

        <!-- Lang Field -->
        <div class="form-group row">
            {!! Html::label('lang', trans('ticketit::admin.config-edit-language') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-9">
                {!! Html::text('lang', $configuration->lang)->class('form-control') !!}
            </div>
        </div>

        <!-- Submit Field -->
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                {!! Html::submit(trans('ticketit::admin.btn-submit'))->class('btn btn-primary') !!}
            </div>
        </div>

    {!! Html::form()->close() !!}

    <script>
        function changeSerialize(e) {
            document.querySelector("#serialize-password").style.display = e.checked ? 'flex' : 'none';
            document.querySelector(".form-text").style.display = e.checked ? 'block' : 'none';
        }

        changeSerialize(document.querySelector("input[name='serialize']"));
    </script>

    @if($should_serialize)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{ Juanrube\Ticketit\Helpers\Cdn::CodeMirror }}/codemirror.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{ Juanrube\Ticketit\Helpers\Cdn::CodeMirror }}/mode/clike/clike.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{ Juanrube\Ticketit\Helpers\Cdn::CodeMirror }}/mode/php/php.min.js"></script>

        <script>
            loadCSS("{!! asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . Juanrube\Ticketit\Helpers\Cdn::CodeMirror . '/codemirror.min.css') !!}");
            loadCSS("{!! asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . Juanrube\Ticketit\Helpers\Cdn::CodeMirror . '/theme/monokai.min.css') !!}");

            window.addEventListener('load', function () {
                CodeMirror.fromTextArea(document.querySelector("textarea[name='value']"), {
                    lineNumbers: true,
                    mode: 'text/x-php',
                    theme: 'monokai',
                    indentUnit: 2,
                    lineWrapping: true
                });
            });
        </script>
    @endif
@stop