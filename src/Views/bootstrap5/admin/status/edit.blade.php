@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.status-edit-title', ['name' => ucwords($status->name)]))

@section('ticketit_content') 
    {!! Html::form()->action(route($setting->grab('admin_route').'.status.update', $status->id))->method('PATCH')->model($status)->open() !!}
        @include('ticketit::admin.status.form', ['update', true])
    {!! Html::form()->close() !!}
@stop
