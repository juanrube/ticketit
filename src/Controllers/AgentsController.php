<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Http\Request;
use Juanrube\Ticketit\Models\Agent;
use App\Http\Controllers\Controller;
use Juanrube\Ticketit\Models\Setting;
use Illuminate\Support\Facades\Session;

class AgentsController extends Controller
{
    public function index()
    {
        $agents = Agent::agents()->get();

        return view('ticketit::admin.agent.index', compact('agents'));
    }

    public function create()
    {
        $users = Agent::paginate(Setting::grab('paginate_items'));

        return view('ticketit::admin.agent.create', compact('users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'agents' => 'required|array|min:1',
            'agents.*' => 'integer|exists:users,id',
        ];


        $request->validate($rules);

        $agents_list = $this->addAgents($request->input('agents'));
        $agents_names = implode(',', $agents_list);

        Session::flash('status', trans('ticketit::lang.agents-are-added-to-agents', ['names' => $agents_names]));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AgentsController@index');
    }

    public function update($id, Request $request)
    {
        $this->syncAgentCategories($id, $request);

        Session::flash('status', trans('ticketit::lang.agents-joined-categories-ok'));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AgentsController@index');
    }

    public function destroy($id)
    {
        $agent = $this->removeAgent($id);

        Session::flash('status', trans('ticketit::lang.agents-is-removed-from-team', ['name' => $agent->name]));

        return redirect()->action('\Juanrube\Ticketit\Controllers\AgentsController@index');
    }

    public function addAgents($user_ids)
    {
        $users = Agent::find($user_ids);
        foreach ($users as $user) {
            $user->ticketit_agent = true;
            $user->save();
            $users_list[] = $user->name;
        }

        return $users_list;
    }

    public function removeAgent($id)
    {
        $agent = Agent::find($id);
        $agent->ticketit_agent = false;
        $agent->save();

        // Remove him from tickets categories as well
        $agent_cats = $agent->categories->pluck('id')->toArray();

        $agent->categories()->detach($agent_cats);

        return $agent;
    }

    public function syncAgentCategories($id, Request $request)
    {
        $form_cats = ($request->input('agent_cats') == null) ? [] : $request->input('agent_cats');
        $agent = Agent::find($id);
        $agent->categories()->sync($form_cats);
    }
}
