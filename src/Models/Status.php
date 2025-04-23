<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'ticketit_statuses';

    protected $fillable = ['name', 'color'];

    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'status_id');
    }
}
