<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsTypesAttributesSet
 *
 * @property int $type_id
 * @property int $set_id
 *
 * @property AttributeSet $attributes_set
 * @property ProductType $products_type
 *
 * @package Domain\Products\Models\Product
 */
class ProductTypeAttributeSet extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'products_types_attributes_sets';

    protected $casts = [
        'type_id' => 'int',
        'set_id' => 'int',
    ];

    public function set()
    {
        return $this->belongsTo(AttributeSet::class, 'set_id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }
}
