<?php

namespace Domain\Products\Models\Product\Option;

use Domain\Content\Models\Image;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductVariantOption;
use Domain\Products\QueryBuilders\ProductOptionValueQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kirschbaum\PowerJoins\PowerJoins;
use Support\Traits\HasModelUtilities;

class ProductOptionValue extends Model
{
    use HasFactory,
        PowerJoins,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'products_options_values';

    protected $casts = [
        'option_id' => 'int',
        'price' => 'float',
        'rank' => 'int',
        'image_id' => 'int',
        'is_custom' => 'bool',
        'status' => 'bool',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'option_id',
        'name',
        'display',
        'price',
        'rank',
        'image_id',
        'is_custom',
        'start_date',
        'end_date',
        'status',
    ];

    public function newEloquentBuilder($query)
    {
        return new ProductOptionValueQuery($query);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function option()
    {
        return $this->belongsTo(ProductOption::class, 'option_id');
    }

    public function orderItemOption(): HasOne
    {
        return $this->hasOne(OrderItemOptionOld::class, 'value_id');
    }

    public function custom()
    {
        return $this->hasOne(ProductOptionCustom::class, 'value_id');
    }
    public function productVariantOption()
    {
        return $this->hasMany(
            ProductVariantOption::class,
            'option_id',
            'id'
        );
    }
    public function variants()
    {
        return $this->belongsToMany(
            Product::class,
            ProductVariantOption::class,
            'option_id',
            'product_id'
        );
    }
    public function translations()
    {
        return $this->hasMany(ProductOptionValueTranslation::class);
    }

//    public function saved_cart_items_options_customvalues()
//    {
//        return $this->hasMany(CartItemOptionCustomValue::class, 'option_id');
//    }

//    public function wishlists_items_options_customvalues()
//    {
//        return $this->hasMany(WishlistsItemsOptionsCustomvalue::class, 'option_id');
//    }
}
