<?php

namespace Domain\Locales\Models;

use Domain\Tax\Models\TaxRuleLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class StateProvince extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'states';

    protected $casts = [
        'country_id' => 'int',
        'tax_rate' => 'float',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'abbreviation',
        'country_id',
        'tax_rate',
        'status',
    ];

    public function taxRules()
    {
        return $this->hasMany(TaxRuleLocation::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
