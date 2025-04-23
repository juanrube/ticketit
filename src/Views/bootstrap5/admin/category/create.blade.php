@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.category-create-title'))

@section('ticketit_content') 
    {!! Html::form()->action(route($setting->grab('admin_route').'.category.store'))->method('POST')->open() !!}
        @include('ticketit::admin.category.form')
    {!! Html::form()->close() !!}
@stop
