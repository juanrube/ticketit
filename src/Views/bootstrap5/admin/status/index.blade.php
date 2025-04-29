@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.status-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.status.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle mr-2"></i>
    {{ trans('ticketit::admin.btn-create-new-status') }}
</a>
@stop

@section('ticketit_content_parent_class', 'p-0')

@section('ticketit_content')
    @if ($statuses->isEmpty())
        <h3 class="text-center">{{ trans('ticketit::admin.status-index-no-statuses') }}
            <a href="{{ route($setting->grab('admin_route').'.status.create') }}">
                {{ trans('ticketit::admin.status-index-create-new') }}
            </a>
        </h3>
    @else
        <div id="message"></div>
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ trans('ticketit::admin.table-id') }}</th>
                    <th>{{ trans('ticketit::admin.table-name') }}</th>
                    <th>{{ trans('ticketit::admin.table-action') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($statuses as $status)
                <tr>
                    <td style="vertical-align: middle">
                        {{ $status->id }}
                    </td>
                    <td style="color: {{ $status->color }}; vertical-align: middle">
                        {{ $status->name }}
                    </td>
                    <td>
                        <a href="{{ route($setting->grab('admin_route').'.status.edit', $status->id) }}" class="btn btn-info">
                            {{ trans('ticketit::admin.btn-edit') }}
                        </a>

                        <a href="{{ route($setting->grab('admin_route').'.status.destroy', $status->id) }}"
                           class="btn btn-danger deleteit"
                           data-form="delete-{{ $status->id }}"
                           data-node="{{ $status->name }}">
                            {{ trans('ticketit::admin.btn-delete') }}
                        </a>

                        {!! Html::form()->action(route($setting->grab('admin_route').'.status.destroy', $status->id))->method('DELETE')->id("delete-$status->id")->open() !!}
                        {!! Html::form()->close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop

@section('footer')
    <script>
        $( ".deleteit" ).click(function( event ) {
            event.preventDefault();
            if (confirm("{!! trans('ticketit::admin.status-index-js-delete') !!}" + $(this).data("node") + " ?"))
            {
                var form = $(this).data("form");
                $("#" + form).submit();
            }
        });
    </script>
@append
