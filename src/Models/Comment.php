<?php

namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;
use Juanrube\Ticketit\Traits\ContentEllipse;
use Juanrube\Ticketit\Traits\Purifiable;

class Comment extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'ticketit_comments';

    public function ticket()
    {
        return $this->belongsTo('Juanrube\Ticketit\Models\Ticket', 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
