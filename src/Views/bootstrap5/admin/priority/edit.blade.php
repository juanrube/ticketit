@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.priority-edit-title', ['name' => ucwords($priority->name)]))

@section('ticketit_content')
    {!! Html::form()->action(route($setting->grab('admin_route').'.priority.update', $priority->id))->method('PATCH')->model($priority)->open() !!}
        @include('ticketit::admin.priority.form', ['update', true])
    {!! Html::form()->close() !!}
@stop
