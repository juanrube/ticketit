<?php



namespace Juanrube\Ticketit\Models;

use Illuminate\Database\Eloquent\Model;
use Juanrube\Ticketit\Traits\ContentEllipse;

class Configuration extends Model
{
    use ContentEllipse;

    public $table = 'ticketit_settings';

    public $fillable = [
        'lang',
        'slug',
        'value',
        'default',
    ];

    // Null lang column if no value is being stored.

    public function setLangAttribute($lang)
    {
        $this->attributes['lang'] = trim($lang) !== '' ? $lang : null;
    }

    protected $casts = [
        'id' => 'integer',
        'lang' => 'string',
        'slug' => 'string',
        'value' => 'string',
        'default' => 'string',
    ];

    public static $rules = [];
}
