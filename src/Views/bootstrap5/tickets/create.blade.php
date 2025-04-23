@extends('ticketit::layouts.master')
@section('page', trans('ticketit::lang.create-ticket-title'))
@section('page_title', trans('ticketit::lang.create-new-ticket'))

@section('ticketit_content')
    {!! Html::form()->action(route($setting->grab('main_route') . '.store'))->method('POST')->open() !!}
        <div class="form-group row">
            {!! Html::label('subject', trans('ticketit::lang.subject') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
            <div class="col-lg-10">
                {!! Html::text('subject', old('subject'))->class('form-control')->required() !!}
                <small class="form-text text-muted">{!! trans('ticketit::lang.create-ticket-brief-issue') !!}</small>
            </div>
        </div>
        <div class="form-group row">
            {!! Html::label('content', trans('ticketit::lang.description') . trans('ticketit::lang.colon'), ['class' => 'col-lg-2 col-form-label']) !!}
            <div class="col-lg-10">
                {!! Html::textarea('content', old('content'))->class('form-control summernote-editor')->rows(5)->required() !!}
                <small class="form-text text-muted">{!! trans('ticketit::lang.create-ticket-describe-issue') !!}</small>
            </div>
        </div>
        <div class="form-row mt-5">
            <div class="form-group col-lg-4 row">
                {!! Html::label('priority', trans('ticketit::lang.priority') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
                <div class="col-lg-6">
                    {!! Html::select('priority_id', $priorities, old('priority_id'))->class('form-control')->required() !!}
                </div>
            </div>
            <div class="form-group offset-lg-1 col-lg-4 row">
                {!! Html::label('category', trans('ticketit::lang.category') . trans('ticketit::lang.colon'), ['class' => 'col-lg-6 col-form-label']) !!}
                <div class="col-lg-6">
                    {!! Html::select('category_id', $categories, old('category_id'))->class('form-control')->required() !!}
                </div>
            </div>
            {!! Html::hidden('agent_id', 'auto') !!}
        </div>
        <br>
        <div class="form-group row">
            <div class="col-lg-10 offset-lg-2">
                <a href="{{ route($setting->grab('main_route') . '.index') }}" class="btn btn-link">
                    {{ trans('ticketit::lang.btn-back') }}
                </a>
                {!! Html::submit(trans('ticketit::lang.btn-submit'))->class('btn btn-primary') !!}
            </div>
        </div>
    {!! Html::form()->close() !!}
@endsection

@section('footer')
    @include('ticketit::tickets.partials.summernote')
@append