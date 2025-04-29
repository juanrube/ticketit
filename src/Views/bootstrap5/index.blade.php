@extends('ticketit::layouts.master')

@section('page', trans('ticketit::lang.index-title'))
@section('page_title', trans('ticketit::lang.index-my-tickets'))

@section('ticketit_header')
<a href="{{ route($setting->grab('main_route').'.create') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle mr-2"></i>
    {{ trans('ticketit::lang.btn-create-new-ticket') }}
</a>
@stop

@section('ticketit_content_parent_class', 'pl-0 pr-0')

@section('ticketit_content')
    <div id="message"></div>
    @include('ticketit::tickets.partials.datatable')
@stop

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.2.2/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/date-1.5.5/r-3.0.4/sp-2.3.3/datatables.min.js" integrity="sha384-bIoLRxA/CDmfyxexpAccKiI/s6gC3Cs2X36IFBdlofgHK6xdXHQMZ3XhPFTTnV4V" crossorigin="anonymous"></script>
<script>
    $('.table').DataTable({
        processing: false,
        serverSide: true,
        responsive: true,
        pageLength: {{ $setting->grab('paginate_items') }},
        lengthMenu: {{ json_encode($setting->grab('length_menu')) }},
        ajax: '{{ route($setting->grab('main_route').'.data', $complete) }}',
        language: {
            decimal:        "{{ trans('ticketit::lang.table-decimal') }}",
            emptyTable:     "{{ trans('ticketit::lang.table-empty') }}",
            info:           "{{ trans('ticketit::lang.table-info') }}",
            infoEmpty:      "{{ trans('ticketit::lang.table-info-empty') }}",
            infoFiltered:   "{{ trans('ticketit::lang.table-info-filtered') }}",
            infoPostFix:    "{{ trans('ticketit::lang.table-info-postfix') }}",
            thousands:      "{{ trans('ticketit::lang.table-thousands') }}",
            lengthMenu:     "{{ trans('ticketit::lang.table-length-menu') }}",
            loadingRecords: "{{ trans('ticketit::lang.table-loading-results') }}",
            processing:     "{{ trans('ticketit::lang.table-processing') }}",
            search:         "{{ trans('ticketit::lang.table-search') }}",
            zeroRecords:    "{{ trans('ticketit::lang.table-zero-records') }}",
            paginate: {
                first:      "{{ trans('ticketit::lang.table-paginate-first') }}",
                last:       "{{ trans('ticketit::lang.table-paginate-last') }}",
                next:       "{{ trans('ticketit::lang.table-paginate-next') }}",
                previous:   "{{ trans('ticketit::lang.table-paginate-prev') }}"
            },
            aria: {
                sortAscending:  "{{ trans('ticketit::lang.table-aria-sort-asc') }}",
                sortDescending: "{{ trans('ticketit::lang.table-aria-sort-desc') }}"
            },
        },
        columns: [
            { data: 'id', name: 'ticketit.id' },
            { data: 'subject', name: 'subject' },
            { data: 'status', name: 'ticketit_statuses.name' },
            { data: 'updated_at', name: 'ticketit.updated_at' },
            { data: 'agent', name: 'users.name' },
            @if( $u->isAgent() || $u->isAdmin() )
                { data: 'priority', name: 'ticketit_priorities.name' },
                { data: 'owner', name: 'users.name' },
                { data: 'category', name: 'ticketit_categories.name' }
            @endif
        ]
    });
</script>
@append
