<?php

namespace Domain\Resorts\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Airport
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<Resort> $resorts
 *
 * @package Domain\Resorts\Models
 */
class Airport extends Model
{
    public $timestamps = false;
    protected $table = 'airports';

    protected $fillable = [
        'name',
    ];

    public function resorts()
    {
        return $this->hasMany(Resort::class);
    }
}
