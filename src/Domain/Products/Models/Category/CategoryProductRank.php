<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriesProductsRank
 *
 * @property int $category_id
 * @property int $product_id
 * @property int $rank
 *
 * @property Category $category
 * @property Product $product
 *
 * @package Domain\Products\Models\Category
 */
class CategoryProductRank extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'categories_products_ranks';

    protected $casts = [
        'category_id' => 'int',
        'product_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'rank',
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
