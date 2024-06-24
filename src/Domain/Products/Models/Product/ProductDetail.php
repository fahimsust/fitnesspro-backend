<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\BelongsTo\BelongsToProduct;
use Support\Traits\HasModelUtilities;

class ProductDetail extends Model
{
    use HasFactory,
        HasModelUtilities,
        BelongsToProduct;

    public $incrementing = false;

    protected $table = 'products_details';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'summary',
        'description',
        'type_id',
        'brand_id',
        'rating',
        'views_30days',
        'views_90days',
        'views_180days',
        'views_1year',
        'views_all',
        'orders_30days',
        'orders_90days',
        'orders_180days',
        'orders_1year',
        'orders_all',
        'downloadable',
        'downloadable_file',
        'default_category_id',
        'orders_updated',
        'views_updated',
        'create_children_auto',
        'display_children_grid',
        'override_parent_description',
        'allow_pricing_discount',
        'attributes',
    ];

    protected $casts = [
        'product_id' => 'int',
        'type_id' => 'int',
        'brand_id' => 'int',
        'rating' => 'float',
        'views_30days' => 'int',
        'views_90days' => 'int',
        'views_180days' => 'int',
        'views_1year' => 'int',
        'views_all' => 'int',
        'orders_30days' => 'int',
        'orders_90days' => 'int',
        'orders_180days' => 'int',
        'orders_1year' => 'int',
        'orders_all' => 'int',
        'downloadable' => 'bool',
        'default_category_id' => 'int',
        'create_children_auto' => 'bool',
        'display_children_grid' => 'bool',
        'override_parent_description' => 'bool',
        'allow_pricing_discount' => 'bool',
        'orders_updated' => 'datetime',
        'views_updated' => 'datetime',
        'attributes' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'default_category_id'
        );
    }

    public function type()
    {
        return $this->belongsTo(
            ProductType::class,
            'type_id'
        );
    }
}
