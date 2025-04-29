@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.category-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.category.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle mr-2"></i>
    {{ trans('ticketit::admin.btn-create-new-category') }}
</a>
@stop

@section('ticketit_content_parent_class', 'p-0')

@section('ticketit_content')
    @if ($categories->isEmpty())
        <h3 class="text-center">{{ trans('ticketit::admin.category-index-no-categories') }}
            <a href="{{ route($setting->grab('admin_route').'.category.create') }}">
                {{ trans('ticketit::admin.category-index-create-new') }}
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
            @foreach($categories as $category)
                <tr>
                    <td style="vertical-align: middle">
                        {{ $category->id }}
                    </td>
                    <td style="color: {{ $category->color }}; vertical-align: middle">
                        {{ $category->name }}
                    </td>
                    <td>
                        <a href="{{ route($setting->grab('admin_route').'.category.edit', $category->id) }}" class="btn btn-info">
                            {{ trans('ticketit::admin.btn-edit') }}
                        </a>

                        <a href="{{ route($setting->grab('admin_route').'.category.destroy', $category->id) }}"
                           class="btn btn-danger deleteit"
                           data-form="delete-{{ $category->id }}"
                           data-node="{{ $category->name }}">
                            {{ trans('ticketit::admin.btn-delete') }}
                        </a>

                        {!! Html::form()->action(route($setting->grab('admin_route').'.category.destroy', $category->id))->method('DELETE')->id("delete-$category->id")->open() !!}
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
            if (confirm("{!! trans('ticketit::admin.category-index-js-delete') !!}" + $(this).data("node") + " ?"))
            {
                var form = $(this).data("form");
                $("#" + form).submit();
            }
        });
    </script>
@append
