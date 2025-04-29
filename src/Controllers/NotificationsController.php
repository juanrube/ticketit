<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Juanrube\Ticketit\Models\Ticket;
use Juanrube\Ticketit\Models\Comment;
use Juanrube\Ticketit\Models\Setting;
use Juanrube\Ticketit\Helpers\LaravelVersion;

class NotificationsController extends Controller
{
    public function newComment(Comment $comment)
    {
        $ticket = $comment->ticket;
        $notification_owner = $comment->user;
        $template = 'ticketit::emails.comment';
        $data = ['comment' => serialize($comment), 'ticket' => serialize($ticket)];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            trans('ticketit::lang.notify-new-comment-from').$notification_owner->name.trans('ticketit::lang.notify-on').$ticket->subject, 'comment');
    }

    public function ticketStatusUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'ticketit::emails.status';
        $data = [
            'ticket' => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket' => serialize($original_ticket),
        ];

        if (strtotime($ticket->completed_at)) {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to-complete'), 'status');
        } else {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('ticketit::lang.notify-updated').$ticket->subject.trans('ticketit::lang.notify-status-to').$ticket->status->name, 'status');
        }
    }

    public function ticketAgentUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'ticketit::emails.transfer';
        $data = [
            'ticket' => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket' => serialize($original_ticket),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('ticketit::lang.notify-transferred').$ticket->subject.trans('ticketit::lang.notify-to-you'), 'agent');
    }

    public function newTicketNotifyAgent(Ticket $ticket)
    {
        $notification_owner = auth()->user();
        $template = 'ticketit::emails.assigned';
        $data = [
            'ticket' => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('ticketit::lang.notify-created-ticket').$ticket->subject, 'agent');
    }

    public function sendNotification($template, $data, $ticket, $notification_owner, $subject, $type)
    {

        $to = null;

        if ($type != 'agent') {
            $to = $ticket->user;

            if ($ticket->user->email != $notification_owner->email) {
                $to = $ticket->user;
            }

            if ($ticket->agent->email != $notification_owner->email) {
                $to = $ticket->agent;
            }
        } else {
            $to = $ticket->agent;
        }

        $mail = new \Juanrube\Ticketit\Mail\TicketitNotification($template, $data, $notification_owner, $subject);

            if (Setting::grab('queue_emails') == 'yes') {
                try {
                    Mail::to($to)->queue($mail);
                } catch (\Throwable $th) {
                    Log::debug("ERROR ENVIANDO EMAIL DE NOTIFACION TICKETIT NotificationController@sendNotification - L:99", [$th->getMessage()]);
                }
            } else {
                try {
                    Mail::to($to)->send($mail);
                } catch (\Throwable $th) {
                    Log::debug("ERROR ENVIANDO EMAIL DE NOTIFACION TICKETIT NotificationController@sendNotification - L:105", [$th->getMessage()]);
                }
            }
    }
}
