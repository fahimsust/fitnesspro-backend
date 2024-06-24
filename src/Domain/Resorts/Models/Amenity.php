<?php

namespace Domain\Resorts\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModResortDetailsAmenity
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<ResortAmenity> $mods_resort_details_amenities
 * @property Amenity $resorts_amenity
 *
 * @package Domain\Resorts\Models
 */
class Amenity extends Model
{
    public $timestamps = false;
    protected $table = 'mod_resort_details_amenities';

    protected $fillable = [
        'name',
    ];

    public function resorts()
    {
        return $this->hasMany(
            Resort::class,
            ResortAmenity::class,
            'amenity_id'
        );
    }
}
