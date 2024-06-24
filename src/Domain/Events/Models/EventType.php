<?php

namespace Domain\Events\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventsType
 *
 * @property int $id
 * @property string $name
 *
 * @package Domain\Events\Models
 */
class EventType extends Model
{
    public $timestamps = false;
    protected $table = 'events_types';

    protected $fillable = [
        'name',
    ];
}
