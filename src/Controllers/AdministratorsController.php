<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Http\Request;
use Juanrube\Ticketit\Models\Agent;
use App\Http\Controllers\Controller;
use Juanrube\Ticketit\Models\Setting;
use Illuminate\Support\Facades\Session;

class AdministratorsController extends Controller
{
    public function index()
    {
        $administrators = Agent::admins();

        return view('ticketit::admin.administrator.index', compact('administrators'));
    }

    public function create()
    {
        $users = Agent::paginate(Setting::grab('paginate_items'));

        return view('ticketit::admin.administrator.create', compact('users'));
    }

    public function store(Request $request)
    {
        $administrators_list = $this->addAdministrators($request->input('administrators'));
        $administrators_names = implode(',', $administrators_list);

        Session::flash('status', trans('ticketit::lang.administrators-are-added-to-administrators', ['names' => $administrators_names]));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AdministratorsController@index');
    }

    public function update($id, Request $request)
    {
        $this->syncAdministratorCategories($id, $request);

        Session::flash('status', trans('ticketit::lang.administrators-joined-categories-ok'));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AdministratorsController@index');
    }

    public function destroy($id)
    {
        $administrator = $this->removeAdministrator($id);

        Session::flash('status', trans('ticketit::lang.administrators-is-removed-from-team', ['name' => $administrator->name]));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AdministratorsController@index');
    }

    public function addAdministrators($user_ids)
    {
        $users = Agent::find($user_ids);
        foreach ($users as $user) {
            $user->ticketit_admin = true;
            $user->save();
            $users_list[] = $user->name;
        }

        return $users_list;
    }

    public function removeAdministrator($id)
    {
        $administrator = Agent::find($id);
        $administrator->ticketit_admin = false;
        $administrator->save();

        // Remove him from tickets categories as well
        $administrator_cats = $administrator->categories->lists('id')->toArray();

        $administrator->categories()->detach($administrator_cats);

        return $administrator;
    }

    public function syncAdministratorCategories($id, Request $request)
    {
        $form_cats = ($request->input('administrator_cats') == null) ? [] : $request->input('administrator_cats');
        $administrator = Agent::find($id);
        $administrator->categories()->sync($form_cats);
    }
}
