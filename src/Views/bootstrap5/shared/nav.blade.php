<nav>
    <ul class="nav nav-pills nav-fill flex-column flex-sm-row">
        <li role="presentation" class="nav-item">
            <a class="nav-link {!! $tools->fullUrlIs(route(Juanrube\Ticketit\Models\Setting::grab('main_route') . '.index')) ? "active" : "" !!}"
                href="{{ route(Juanrube\Ticketit\Models\Setting::grab('main_route') . '.index') }}">{{ trans('ticketit::lang.nav-active-tickets') }}
                <span class="badge bg-danger ml-1">
                     <?php 
                        if ($u->isAdmin()) {
                            echo Juanrube\Ticketit\Models\Ticket::active()->count();
                        } elseif ($u->isAgent()) {
                            echo Juanrube\Ticketit\Models\Ticket::active()->agentUserTickets($u->id)->count();
                        } else {
                            echo Juanrube\Ticketit\Models\Ticket::userTickets($u->id)->active()->count();
                        }
                    ?>
                </span>
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a class="nav-link {!! $tools->fullUrlIs(route(Juanrube\Ticketit\Models\Setting::grab('main_route') . '-complete')) ? "active" : "" !!}"
                 href="{{ route(Juanrube\Ticketit\Models\Setting::grab('main_route') . '-complete') }}">{{ trans('ticketit::lang.nav-completed-tickets') }}
                <span class="badge bg-danger ml-1">
                    <?php 
                        if ($u->isAdmin()) {
                            echo Juanrube\Ticketit\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo Juanrube\Ticketit\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo Juanrube\Ticketit\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
            </a>
        </li>

        @if($u->isAdmin())
            <li role="presentation" class="nav-item">
                <a class="nav-link {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\DashboardController@index')) || Request::is($setting->grab('admin_route').'/indicator*') ? "active" : "" !!}"
                    href="{{ action('\Juanrube\Ticketit\Controllers\DashboardController@index') }}">{{ trans('ticketit::admin.nav-dashboard') }}</a>
            </li>

            <li role="presentation" class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {!!
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\StatusesController@index').'*') ||
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\PrioritiesController@index').'*') ||
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\AgentsController@index').'*') ||
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\CategoriesController@index').'*') ||
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\ConfigurationsController@index').'*') ||
                    $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\AdministratorsController@index').'*')
                    ? "active" : "" !!}"
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ trans('ticketit::admin.nav-settings') }}
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\StatusesController@index').'*') ? "active" : "" !!}"
                        href="{{ action('\Juanrube\Ticketit\Controllers\StatusesController@index') }}">{{ trans('ticketit::admin.nav-statuses') }}</a>
                    </li>
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\PrioritiesController@index').'*') ? "active" : "" !!}"
                        href="{{ action('\Juanrube\Ticketit\Controllers\PrioritiesController@index') }}">{{ trans('ticketit::admin.nav-priorities') }}</a>
                    </li>
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\AgentsController@index').'*') ? "active" : "" !!}"
                        href="{{ action('\Juanrube\Ticketit\Controllers\AgentsController@index') }}">{{ trans('ticketit::admin.nav-agents') }}</a>
                    </li>
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\CategoriesController@index').'*') ? "active" : "" !!}"
                            href="{{ action('\Juanrube\Ticketit\Controllers\CategoriesController@index') }}">{{ trans('ticketit::admin.nav-categories') }}</a>
                    </li>
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\ConfigurationsController@index').'*') ? "active" : "" !!}"
                            href="{{ action('\Juanrube\Ticketit\Controllers\ConfigurationsController@index') }}">{{ trans('ticketit::admin.nav-configuration') }}</a>
                    </li>
                    <li>
                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Juanrube\Ticketit\Controllers\AdministratorsController@index').'*') ? "active" : "" !!}"
                            href="{{ action('\Juanrube\Ticketit\Controllers\AdministratorsController@index')}}">{{ trans('ticketit::admin.nav-administrator') }}</a>
                    </li>
                  </ul>
            </li>
        @endif

    </ul>
</nav>