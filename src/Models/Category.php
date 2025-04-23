<?php

declare(strict_types=1);

namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ticketit_categories';

    protected $fillable = ['name', 'color'];

    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('Juanrube\Ticketit\Models\Ticket', 'category_id');
    }

    public function agents()
    {
        return $this->belongsToMany('\Juanrube\Ticketit\Models\Agent', 'ticketit_categories_users', 'category_id', 'user_id');
    }
}
