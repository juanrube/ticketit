<div class="form-group">
    {!! Html::label('name', trans('ticketit::admin.status-create-name') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::text('name', isset($status->name) ? $status->name : null)->class('form-control') !!}
</div>
<div class="form-group">
    {!! Html::label('color', trans('ticketit::admin.status-create-color') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::input('color', 'color', isset($status->color) ? $status->color : "#000000")->class('form-control') !!}
</div>

<a href="{{ route($setting->grab('admin_route').'.status.index') }}" class="btn btn-link">
    {{ trans('ticketit::admin.btn-back') }}
</a>
@if(isset($status))
    {!! Html::submit(trans('ticketit::admin.btn-update'))->class('btn btn-primary') !!}
@else
    {!! Html::submit(trans('ticketit::admin.btn-submit'))->class('btn btn-primary') !!}
@endif
