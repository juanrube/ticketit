<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Console;

use Illuminate\Console\Command;
use Juanrube\Ticketit\Models\Comment;
use Juanrube\Ticketit\Models\Ticket;

class Htmlify extends Command
{

    protected $signature = 'ticketit:htmlify';

    protected $description = 'Copies column `content` to column `html` in comments and tickets tables while escaping and replacing new lines with <br> tags. Run this when upgrading from <=v0.2.2';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            if (! $ticket->html) {
                $ticket->html = nl2br(e($ticket->content));
                $ticket->content = e($ticket->content);
                $ticket->save();
            }
        }

        $comments = Comment::all();

        foreach ($comments as $comment) {
            if (! $comment->html) {
                $comment->html = nl2br(e($comment->content));
                $comment->content = e($comment->content);
                $comment->save();
            }
        }
    }
}
