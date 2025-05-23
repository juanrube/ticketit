<?php



namespace Juanrube\Ticketit\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketitNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $template;

    private $data;

    private $notification_owner;

    public $subject;

    public function __construct($template, $data, $notification_owner, $subject)
    {
        $this->template = $template;
        $this->data = $data;
        $this->notification_owner = $notification_owner;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->replyTo($this->notification_owner->email, $this->notification_owner->name)
            ->view($this->template)
            ->with($this->data);
    }
}
