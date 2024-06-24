<?php

namespace Domain\Products\Models\DatesAutoOrderRules;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsDatesAutoOrderrulesProduct
 *
 * @property int $id
 * @property int $dao_id
 * @property int $product_id
 *
 * @property DatesAutoOrderRule $mods_dates_auto_orderrule
 * @property Product $product
 *
 * @package Domain\Products\Models\Mods
 */
class DatesAutoOrderRuleInclude extends Model
{
    public $timestamps = false;
    protected $table = 'dates_auto_orderrules_products';

    protected $casts = [
        'dao_id' => 'int',
        'product_id' => 'int',
    ];

    protected $fillable = [
        'dao_id',
        'product_id',
    ];

    public function autoOrderRule()
    {
        return $this->belongsTo(DatesAutoOrderRule::class, 'dao_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
