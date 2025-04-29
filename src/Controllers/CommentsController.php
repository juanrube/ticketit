<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Juanrube\Ticketit\Models;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('Juanrube\Ticketit\Middleware\IsAdminMiddleware', ['only' => ['edit', 'update', 'destroy']]);
        $this->middleware('Juanrube\Ticketit\Middleware\ResAccessMiddleware', ['only' => 'store']);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:ticketit,id',
            'content' => 'required|min:6',
        ]);

        $comment = new Models\Comment;

        $comment->setPurifiedContent($request->get('content'));

        $comment->ticket_id = $request->get('ticket_id');
        $comment->user_id = Auth::user()->id;
        $comment->save();

        $ticket = Models\Ticket::find($comment->ticket_id);
        $ticket->updated_at = $comment->created_at;
        $ticket->save();

        return back()->with('status', trans('ticketit::lang.comment-has-been-added-ok'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
