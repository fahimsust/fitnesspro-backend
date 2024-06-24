<?php

namespace Domain\Resorts\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsResortDetailsAmenity
 *
 * @property int $id
 * @property int $resort_details_id
 * @property int $amenity_id
 * @property int $details
 *
 * @property Amenity $mod_resort_details_amenity
 * @property Resort $mods_resort_detail
 *
 * @package Domain\Resorts\Models
 */
class ResortAmenity extends Model
{
    public $timestamps = false;
    protected $table = 'resort_details_amenities';

    protected $casts = [
        'resort_details_id' => 'int',
        'amenity_id' => 'int',
        'details' => 'int',
    ];

    protected $fillable = [
        'resort_details_id',
        'amenity_id',
        'details',
    ];

    public function amenity()
    {
        return $this->belongsTo(
            Amenity::class,
            'amenity_id'
        );
    }

    public function resort()
    {
        return $this->belongsTo(
            Resort::class,
            'resort_details_id'
        );
    }
}
