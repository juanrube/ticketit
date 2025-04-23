<div class="form-group">
    {!! Html::label('name', trans('ticketit::admin.category-create-name') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::text('name', isset($category->name) ? $category->name : null)->class('form-control') !!}
</div>
<div class="form-group">
    {!! Html::label('color', trans('ticketit::admin.category-create-color') . trans('ticketit::admin.colon'), ['class' => '']) !!}
    {!! Html::input('color', 'color', isset($category->color) ? $category->color : "#000000")->class('form-control') !!}
</div>

<a href="{{ route($setting->grab('admin_route').'.category.index') }}" class="btn btn-link">
    {{ trans('ticketit::admin.btn-back') }}
</a>
@if(isset($category))
    {!! Html::submit(trans('ticketit::admin.btn-update'))->class('btn btn-primary') !!}
@else
    {!! Html::submit(trans('ticketit::admin.btn-submit'))->class('btn btn-primary') !!}
@endif

