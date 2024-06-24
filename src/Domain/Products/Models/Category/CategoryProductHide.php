<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesProductsHide
 *
 * @property int $category_id
 * @property int $product_id
 *
 * @property Category $category
 * @property Product $product
 *
 * @package Domain\Products\Models\Category
 */
class CategoryProductHide extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;

    protected $table = 'categories_products_hide';

    protected $casts = [
        'category_id' => 'int',
        'product_id' => 'int',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
