<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Juanrube\Ticketit\Traits\ContentEllipse;
use Juanrube\Ticketit\Traits\Purifiable;

class Ticket extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'ticketit';

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function hasComments()
    {
        return (bool) count($this->comments);
    }

    public function isComplete()
    {
        return (bool) $this->completed_at;
    }

    public function scopeComplete($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('completed_at');
    }

    public function status()
    {
        return $this->belongsTo('Juanrube\Ticketit\Models\Status', 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo('Juanrube\Ticketit\Models\Priority', 'priority_id');
    }

    public function category()
    {
        return $this->belongsTo('Juanrube\Ticketit\Models\Category', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo('Juanrube\Ticketit\Models\Agent', 'agent_id');
    }

    public function comments()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Comment', 'ticket_id');
    }

    public function freshTimestamp()
    {
        return Carbon::now(); // Usamos Carbon en lugar de Jenssegers\Date
    }

    protected function asDateTime($value)
    {
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value); // Usamos Carbon
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            return Carbon::createFromFormat('Y-m-d', $value)->startOfDay(); // Usamos Carbon
        } elseif (! $value instanceof \DateTimeInterface) {
            $format = $this->getDateFormat();

            return Carbon::createFromFormat($format, $value); // Usamos Carbon
        }

        return Carbon::instance($value); // Usamos Carbon
    }

    public function scopeUserTickets($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeAgentTickets($query, $id)
    {
        return $query->where('agent_id', $id);
    }

    public function scopeAgentUserTickets($query, $id)
    {
        return $query->where(function ($subquery) use ($id) {
            $subquery->where('agent_id', $id)->orWhere('user_id', $id);
        });
    }

    public function autoSelectAgent()
    {
        $cat_id = $this->category_id;
        $agents = Category::find($cat_id)->agents()->with(['agentOpenTickets' => function ($query) {
            $query->addSelect(['id', 'agent_id']);
        }])->get();
        $count = 0;
        $lowest_tickets = 1000000;
        // If no agent selected, select the admin
        $first_admin = Agent::admins()->first();
        $selected_agent_id = $first_admin->id;
        foreach ($agents as $agent) {
            if ($count == 0) {
                $lowest_tickets = $agent->agentOpenTickets->count();
                $selected_agent_id = $agent->id;
            } else {
                $tickets_count = $agent->agentOpenTickets->count();
                if ($tickets_count < $lowest_tickets) {
                    $lowest_tickets = $tickets_count;
                    $selected_agent_id = $agent->id;
                }
            }
            $count++;
        }
        $this->agent_id = $selected_agent_id;

        return $this;
    }
}
