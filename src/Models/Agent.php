<?php



namespace Juanrube\Ticketit\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Agent extends User
{
    protected $table = 'users';

    public function scopeAgents($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('ticketit_agent', '1')->paginate($paginate, ['*'], 'agents_page');
        } else {
            return $query->where('ticketit_agent', '1');
        }
    }

    public function scopeAdmins($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('ticketit_admin', '1')->paginate($paginate, ['*'], 'admins_page');
        } else {
            return $query->where('ticketit_admin', '1')->get();
        }
    }

    public function scopeUsers($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('ticketit_agent', '0')->paginate($paginate, ['*'], 'users_page');
        } else {
            return $query->where('ticketit_agent', '0')->get();
        }
    }

    public function scopeAgentsLists($query)
    {
        return $query->where('ticketit_agent', '1')->pluck('name', 'id')->toArray();
    }

    public static function isAgent($id = null)
    {
        if (isset($id)) {
            $user = User::find($id);
            if ($user->ticketit_agent) {
                return true;
            }

            return false;
        }
        if (auth()->check()) {
            if (auth()->user()->ticketit_agent) {
                return true;
            }
        }

        return false;
    }

    public static function isAdmin()
    {
        return auth()->check() && auth()->user()->ticketit_admin;
    }

    public static function isAssignedAgent($id)
    {
        return auth()->check() &&
            Auth::user()->ticketit_agent &&
            Auth::user()->id == Ticket::find($id)->agent->id;
    }

    public static function isTicketOwner($id)
    {
        $ticket = Ticket::find($id);

        return $ticket && auth()->check() &&
            auth()->user()->id == $ticket->user->id;
    }

    public function categories()
    {
        return $this->belongsToMany('Juanrube\Ticketit\Models\Category', 'ticketit_categories_users', 'user_id', 'category_id');
    }

    public function agentTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'agent_id')->whereNull('completed_at');
        }
    }

    public function userTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function tickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function allTickets($complete = false) // (To be deprecated)
    {
        if ($complete) {
            return Ticket::whereNotNull('completed_at');
        } else {
            return Ticket::whereNull('completed_at');
        }
    }

    public function getTickets($complete = false) // (To be deprecated)
    {
        $user = self::find(auth()->user()->id);

        if ($user->isAdmin()) {
            $tickets = $user->allTickets($complete);
        } elseif ($user->isAgent()) {
            $tickets = $user->agentTickets($complete);
        } else {
            $tickets = $user->userTickets($complete);
        }

        return $tickets;
    }

    public function agentTotalTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'agent_id');
    }

    public function agentCompleteTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
    }

    public function agentOpenTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'agent_id')->whereNull('completed_at');
    }

    public function userTotalTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id');
    }

    public function userCompleteTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNotNull('completed_at');
    }

    public function userOpenTickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'user_id')->whereNull('completed_at');
    }
}
