@extends('ticketit::layouts.master')

@section('page', trans('ticketit::admin.config-index-title'))

@section('ticketit_header')
<a href="{{ route($setting->grab('admin_route').'.configuration.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle mr-2"></i>
    {{ trans('ticketit::admin.btn-create-new-config') }}
</a>
@stop

@section('ticketit_content_parent_class', 'pl-0 pr-0 pb-0')

@section('ticketit_content')
<!-- configuration -->
    @if($configurations->isEmpty())
        <div class="text-center">{{ trans('ticketit::admin.config-index-no-settings') }}</div>
    @else
        <ul class="nav nav-tabs nav-fill" id="configTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#init-configs" data-bs-target="#init-configs">
                    {{ trans('ticketit::admin.config-index-initial') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#ticket-configs" data-bs-target="#ticket-configs">
                    {{ trans('ticketit::admin.config-index-tickets') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#email-configs" data-bs-target="#email-configs">
                    {{ trans('ticketit::admin.config-index-notifications') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#perms-configs" data-bs-target="#perms-configs">
                    {{ trans('ticketit::admin.config-index-permissions') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#editor-configs" data-bs-target="#editor-configs">
                    {{ trans('ticketit::admin.config-index-editor') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#other-configs" data-bs-target="#other-configs">
                    {{ trans('ticketit::admin.config-index-other') }}
                </a>
            </li>
        </ul>

        <div class="tab-content" id="configTabContent">
            <div id="init-configs" class="tab-pane fade show active" role="tabpanel">
                @include('ticketit::admin.configuration.tables.init_table')
            </div>
            <div id="ticket-configs" class="tab-pane fade" role="tabpanel">
                @include('ticketit::admin.configuration.tables.ticket_table')
            </div>
            <div id="email-configs" class="tab-pane fade" role="tabpanel">
                @include('ticketit::admin.configuration.tables.email_table')
            </div>
            <div id="perms-configs" class="tab-pane fade" role="tabpanel">
                @include('ticketit::admin.configuration.tables.perms_table')
            </div>
            <div id="editor-configs" class="tab-pane fade" role="tabpanel">
                @include('ticketit::admin.configuration.tables.editor_table')
            </div>
            <div id="other-configs" class="tab-pane fade" role="tabpanel">
                @include('ticketit::admin.configuration.tables.other_table')
            </div>
        </div>
    @endif
<!-- // Configuration -->
@endsection
