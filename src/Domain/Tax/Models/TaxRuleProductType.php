<?php

namespace Domain\Tax\Models;

use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class TaxRulesProductType
 *
 * @property int $tax_rule_id
 * @property int $type_id
 *
 * @property TaxRule $tax_rule
 * @property ProductType $products_type
 *
 * @package Domain\Tax\Models
 */
class TaxRuleProductType extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'tax_rules_product_types';

    protected $casts = [
        'tax_rule_id' => 'int',
        'type_id' => 'int',
    ];

    public function taxRule()
    {
        return $this->belongsTo(TaxRule::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }
}
