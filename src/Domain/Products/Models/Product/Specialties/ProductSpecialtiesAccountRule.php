<?php

namespace Domain\Products\Models\Product\Specialties;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsSpecialtiesaccountsrule
 *
 * @property int $id
 * @property string $accounts
 * @property string $specialties
 * @property int $rule_id
 *
 * @package Domain\Products\Models\Product
 */
class ProductSpecialtiesAccountRule extends Model
{
    public $timestamps = false;
    protected $table = 'products_specialtiesaccountsrules';

    protected $casts = [
        'rule_id' => 'int',
    ];

    protected $fillable = [
        'accounts',
        'specialties',
        'rule_id',
    ];

    public function rule()
    {
        return $this->belongsTo(
            OrderingRule::class,
            'rule_id'
        );
    }
}
