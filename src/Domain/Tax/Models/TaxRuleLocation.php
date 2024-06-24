<?php

namespace Domain\Tax\Models;

use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxRulesLocation
 *
 * @property int $id
 * @property int $tax_rule_id
 * @property string $name
 * @property bool $type
 * @property int $country_id
 * @property int $state_id
 * @property string $zipcode
 * @property bool $status
 *
 * @property Country $country
 * @property StateProvince $state
 * @property TaxRule $tax_rule
 *
 * @package Domain\Tax\Models
 */
class TaxRuleLocation extends Model
{
    public $timestamps = false;
    protected $table = 'tax_rules_locations';

    protected $casts = [
        'tax_rule_id' => 'int',
        'type' => 'bool',
        'country_id' => 'int',
        'state_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'tax_rule_id',
        'name',
        'type',
        'country_id',
        'state_id',
        'zipcode',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(StateProvince::class);
    }

    public function rule()
    {
        return $this->belongsTo(TaxRule::class);
    }
}
