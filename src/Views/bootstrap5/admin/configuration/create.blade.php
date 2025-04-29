@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.config-create-subtitle'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.configuration.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left mr-2"></i>
    {{ trans('ticketit::admin.btn-back') }}
</a>
@stop

@section('ticketit_content')
    {!! Html::form()->action(route($setting->grab('admin_route').'.configuration.store'))->open() !!}

        <!-- Slug Field -->
        <div class="form-group row mt-3">
            {!! Html::label('slug', trans('ticketit::admin.config-edit-slug') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-10">
                {!! Html::text('slug')->class('form-control') !!}
            </div>
        </div>

        <!-- Default Field -->
        <div class="form-group row mt-3">
            {!! Html::label('default', trans('ticketit::admin.config-edit-default') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-10">
                {!! Html::text('default')->class('form-control') !!}
            </div>
        </div>

        <!-- Value Field -->
        <div class="form-group row mt-3">
            {!! Html::label('value', trans('ticketit::admin.config-edit-value') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-10">
                {!! Html::text('value')->class('form-control') !!}
            </div>
        </div>

        <!-- Lang Field -->
        <div class="form-group row mt-3">
            {!! Html::label('lang', trans('ticketit::admin.config-edit-language') . trans('ticketit::admin.colon'))->class('col-sm-2 col-form-label') !!}
            <div class="col-sm-10">
                {!! Html::text('lang')->class('form-control') !!}
            </div>
        </div>

        <!-- Submit Field -->
        <div class="form-group row mt-5">
            <div class="d-grid gap-2 col-4 mx-auto">
                {!! Html::submit(trans('ticketit::admin.btn-submit'))->class('btn btn-primary btn-block') !!}
            </div>
        </div>

    {!! Html::form()->close() !!}
@stop

@section('footer')
    <script>
      $(document).ready(function() {
        $("#slug").bind('change', function() {
          var slugger = $('#slug').val();
              slugger = slugger       
              .replace(/\W/g, '.')      
              .toLowerCase();
          $("#slug").val(slugger);
        });

        $("#default").bind('keyup blur keypress change', function() {
          var duplicate = $('#default').val();
          $("#value").val(duplicate);
        });
      });
    </script>
@append