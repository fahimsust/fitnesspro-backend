<?php

namespace Domain\Locales\Models;

use Domain\Resorts\Models\Resort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Region extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'countries_regions';

    protected $casts = [
        'country_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'country_id',
        'name',
        'rank',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function resorts()
    {
        return $this->hasMany(Resort::class, 'region_id');
    }
}
