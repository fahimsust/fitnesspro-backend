<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasTableAlias;
use Support\Traits\HasModelUtilities;

class ProductAttribute extends Model
{
    use HasTableAlias;
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'products_attributes';

    protected $casts = [
        'product_id' => 'int',
        'option_id' => 'int',
    ];

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'option_id');
    }

    public function attribute()
    {
        return $this->hasOneThrough(
            Attribute::class,
            AttributeOption::class,
            'id',
            'id',
            'option_id',
            'attribute_id'
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
