<?php

namespace Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HelpPop
 *
 * @property int $id
 * @property string $title
 * @property string $message
 *
 * @package Domain\Others\Models
 */
class HelpPop extends Model
{
    public $timestamps = false;
    protected $table = 'help_pops';

    protected $fillable = [
        'title',
        'message',
    ];
}
