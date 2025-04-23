<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'ticketit_priorities';

    protected $fillable = ['name', 'color'];

    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'priority_id');
    }
}
