@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.priority-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.priority.create') }}" class="btn btn-primary">
    {{ trans('ticketit::admin.btn-create-new-priority') }}
</a>
@stop

@section('ticketit_content_parent_class', 'p-0')

@section('ticketit_content')
    @if ($priorities->isEmpty())
        <h3 class="text-center">{{ trans('ticketit::admin.priority-index-no-priorities') }}
            <a href="{{ route($setting->grab('admin_route').'.priority.create') }}">
                {{ trans('ticketit::admin.priority-index-create-new') }}
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
            @foreach($priorities as $priority)
                <tr>
                    <td style="vertical-align: middle">
                        {{ $priority->id }}
                    </td>
                    <td style="color: {{ $priority->color }}; vertical-align: middle">
                        {{ $priority->name }}
                    </td>
                    <td>
                        <a href="{{ route($setting->grab('admin_route').'.priority.edit', $priority->id) }}" class="btn btn-info">
                            {{ trans('ticketit::admin.btn-edit') }}
                        </a>

                        <a href="{{ route($setting->grab('admin_route').'.priority.destroy', $priority->id) }}"
                           class="btn btn-danger deleteit"
                           data-form="delete-{{ $priority->id }}"
                           data-node="{{ $priority->name }}">
                            {{ trans('ticketit::admin.btn-delete') }}
                        </a>

                        {!! Html::form()->action(route($setting->grab('admin_route').'.priority.destroy', $priority->id))->method('DELETE')->id("delete-$priority->id")->open() !!}
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
            if (confirm("{!! trans('ticketit::admin.priority-index-js-delete') !!}" + $(this).data("node") + " ?"))
            {
                var form = $(this).data("form");
                $("#" + form).submit();
            }
        });
    </script>
@append
