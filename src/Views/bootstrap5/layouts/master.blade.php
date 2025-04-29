@extends($master)

@section('content')
    @include('ticketit::shared.header')

    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                @include('ticketit::shared.nav')
            </div>
        </div>
        @if(View::hasSection('ticketit_content'))
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                    @if(View::hasSection('page_title'))
                        <span class="mx-2 my-2">@yield('page_title')</span>
                    @else
                        <span class="mx-2 my-2">@yield('page')</span>
                    @endif

                    @yield('ticketit_header')
                </h5>
                <div class="card-body @yield('ticketit_content_parent_class')">
                    @yield('ticketit_content')
                </div>
            </div>
        @endif
        @yield('ticketit_extra_content')
    </div>
@stop
