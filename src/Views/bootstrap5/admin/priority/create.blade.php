@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.priority-create-title'))

@section('ticketit_content') 
    {!! Html::form()->action(route($setting->grab('admin_route').'.priority.store'))->method('POST')->open() !!}
        @include('ticketit::admin.priority.form')
    {!! Html::form()->close() !!}
@stop