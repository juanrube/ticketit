<div class="form-group">
    {!! Html::label('name', trans('ticketit::admin.priority-create-name') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::text('name', isset($priority->name) ? $priority->name : null)->class('form-control') !!}
</div>
<div class="form-group">
    {!! Html::label('color', trans('ticketit::admin.priority-create-color') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::input('color', 'color', isset($priority->color) ? $priority->color : "#000000")->class('form-control') !!}
</div>

<a href="{{ route($setting->grab('admin_route').'.priority.index') }}" class="btn btn-link">
    {{ trans('ticketit::admin.btn-back') }}
</a>
@if(isset($priority))
    {!! Html::submit(trans('ticketit::admin.btn-update'))->class('btn btn-primary') !!}
@else
    {!! Html::submit(trans('ticketit::admin.btn-submit'))->class('btn btn-primary') !!}
@endif