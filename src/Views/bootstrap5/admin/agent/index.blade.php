@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.agent-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.agent.create') }}" class="btn btn-primary">
    {{ trans('ticketit::admin.btn-create-new-agent') }}
</a>
@stop

@section('ticketit_content_parent_class', 'p-0')

@section('ticketit_content')
    @if ($agents->isEmpty())
        <h3 class="text-center">{{ trans('ticketit::admin.agent-index-no-agents') }}
            <a href="{{ route($setting->grab('admin_route').'.agent.create') }}">
                {{ trans('ticketit::admin.agent-index-create-new') }}
            </a>
        </h3>
    @else
        <div id="message"></div>
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ trans('ticketit::admin.table-id') }}</th>
                    <th>{{ trans('ticketit::admin.table-name') }}</th>
                    <th>{{ trans('ticketit::admin.table-categories') }}</th>
                    <th>{{ trans('ticketit::admin.table-join-category') }}</th>
                    <th>{{ trans('ticketit::admin.table-remove-agent') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($agents as $agent)
                <tr>
                    <td>
                        {{ $agent->id }}
                    </td>
                    <td>
                        {{ $agent->name }}
                    </td>
                    <td>
                        @foreach($agent->categories as $category)
                            <span style="color: {{ $category->color }}">
                                {{  $category->name }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        {!! Html::form()->action(route($setting->grab('admin_route').'.agent.update', $agent->id))->method('PATCH')->open() !!}
                        @foreach(\Juanrube\Ticketit\Models\Category::all() as $agent_cat)
                            <input name="agent_cats[]"
                                   type="checkbox"
                                   class="form-check-input"
                                   value="{{ $agent_cat->id }}"
                                   {!! ($agent_cat->agents()->where("id", $agent->id)->count() > 0) ? "checked" : ""  !!}>
                                   {{ $agent_cat->name }}
                        @endforeach
                        {!! Html::submit(trans('ticketit::admin.btn-join'))->class('btn btn-info btn-sm') !!}
                        {!! Html::form()->close() !!}
                    </td>
                    <td>
                        {!! Html::form()->action(route($setting->grab('admin_route').'.agent.destroy', $agent->id))->method('DELETE')->id("delete-$agent->id")->open() !!}
                        {!! Html::submit(trans('ticketit::admin.btn-remove'))->class('btn btn-danger') !!}
                        {!! Html::form()->close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop
