<?php

namespace Domain\Locales\Models;

use Domain\Locales\Models\QueryBuilders\CountryQuery;
use Domain\Tax\Models\TaxRuleLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Country extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'countries';

    protected $casts = [
        'status' => 'bool',
        'rank' => 'int',
    ];

    protected $fillable = [
        'name',
        'abbreviation',
        'status',
        'rank',
        'iso_code',
    ];
    public function newEloquentBuilder($query)
    {
        return new CountryQuery($query);
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function stateProvinces()
    {
        return $this->hasMany(StateProvince::class, 'country_id');
    }

    public function taxRules()
    {
        return $this->hasMany(TaxRuleLocation::class);
    }
}
