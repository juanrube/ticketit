<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Juanrube\Ticketit\Helpers\LaravelVersion;
use Juanrube\Ticketit\Models\Status;

class StatusesController extends Controller
{

    public function index()
    {
        // seconds expected for L5.8<=, minutes before that
        $time = 60 * 60;
        $statuses = Cache::remember('ticketit::statuses', $time, function () {
            return Status::all();
        });

        return view('ticketit::admin.status.index', compact('statuses'));
    }

    public function create()
    {
        return view('ticketit::admin.status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $status = new Status;
        $status->create(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.status-name-has-been-created', ['name' => $request->name]));

        Cache::forget('ticketit::statuses');

        return redirect()->action('\Juanrube\Ticketit\Controllers\StatusesController@index');
    }

    public function show($id)
    {
        return trans('ticketit::lang.status-all-tickets-here');
    }

    public function edit($id)
    {
        $status = Status::findOrFail($id);

        return view('ticketit::admin.status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $status = Status::findOrFail($id);
        $status->update(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.status-name-has-been-modified', ['name' => $request->name]));

        Cache::forget('ticketit::statuses');

        return redirect()->action('\Juanrube\Ticketit\Controllers\StatusesController@index');
    }

    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $name = $status->name;
        $status->delete();

        Session::flash('status', trans('ticketit::lang.status-name-has-been-deleted', ['name' => $name]));

        Cache::forget('ticketit::statuses');

        return redirect()->action('\Juanrube\Ticketit\Controllers\StatusesController@index');
    }
}
