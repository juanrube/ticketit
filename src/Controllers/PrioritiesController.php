<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Juanrube\Ticketit\Helpers\LaravelVersion;
use Juanrube\Ticketit\Models\Priority;

class PrioritiesController extends Controller
{

    public function index()
    {
        // seconds expected for L5.8<=, minutes before that
        $time = 60 * 60;
        $priorities = Cache::remember('ticketit::priorities', $time, function () {
            return Priority::all();
        });

        return view('ticketit::admin.priority.index', compact('priorities'));
    }

    public function create()
    {
        return view('ticketit::admin.priority.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $priority = new Priority;
        $priority->create(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.priority-name-has-been-created', ['name' => $request->name]));

        Cache::forget('ticketit::priorities');

        return redirect()->action('\Juanrube\Ticketit\Controllers\PrioritiesController@index');
    }

    public function show($id)
    {
        return trans('ticketit::lang.priority-all-tickets-here');
    }

    public function edit($id)
    {
        $priority = Priority::findOrFail($id);

        return view('ticketit::admin.priority.edit', compact('priority'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $priority = Priority::findOrFail($id);
        $priority->update(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.priority-name-has-been-modified', ['name' => $request->name]));

        Cache::forget('ticketit::priorities');

        return redirect()->action('\Juanrube\Ticketit\Controllers\PrioritiesController@index');
    }

    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);
        $name = $priority->name;
        $priority->delete();

        Session::flash('status', trans('ticketit::lang.priority-name-has-been-deleted', ['name' => $name]));

        Cache::forget('ticketit::priorities');

        return redirect()->action('\Juanrube\Ticketit\Controllers\PrioritiesController@index');
    }
}
