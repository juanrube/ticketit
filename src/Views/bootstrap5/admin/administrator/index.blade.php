@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.administrator-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.administrator.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle mr-2"></i>
    {{ trans('ticketit::admin.btn-create-new-administrator') }}
</a>
@stop

@section('ticketit_content_parent_class', 'p-0')

@section('ticketit_content')
    @if ($administrators->isEmpty())
        <h3 class="text-center">{{ trans('ticketit::admin.administrator-index-no-administrators') }}
            <a href="{{ route($setting->grab('admin_route').'.administrator.create') }}">
                {{ trans('ticketit::admin.administrator-index-create-new') }}
            </a>
        </h3>
    @else
        <div id="message"></div>
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>{{ trans('ticketit::admin.table-id') }}</th>
                <th>{{ trans('ticketit::admin.table-name') }}</th>
                <th>{{ trans('ticketit::admin.table-remove-administrator') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($administrators as $administrator)
                <tr>
                    <td>
                        {{ $administrator->id }}
                    </td>
                    <td>
                        {{ $administrator->name }}
                    </td>
                    <td>
                        {!! Html::form()->action(route($setting->grab('admin_route').'.administrator.destroy', $administrator->id))->method('DELETE')->id("delete-$administrator->id")->open() !!}
                        {!! Html::submit(trans('ticketit::admin.btn-remove'))->class('btn btn-danger') !!}
                        {!! Html::form()->close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop
