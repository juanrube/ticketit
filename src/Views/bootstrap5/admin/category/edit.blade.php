@extends('ticketit::layouts.master')
@section('page', trans('ticketit::admin.category-edit-title', ['name' => ucwords($category->name)]))

@section('ticketit_content')
    {!! Html::form()->action(route($setting->grab('admin_route').'.category.update', $category->id))->method('PATCH')->model($category)->open() !!}
        @include('ticketit::admin.category.form', ['update', true])
    {!! Html::form()->close() !!}
@stop
