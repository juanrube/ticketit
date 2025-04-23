@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.status-create-title'))

@section('ticketit_content') 
    {!! Html::form()->action(route($setting->grab('admin_route').'.status.store'))->method('POST')->open() !!}
        @include('ticketit::admin.status.form')
    {!! Html::form()->close() !!}
@stop
