<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Product\ProductSortOption;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriesProductsSort
 *
 * @property int $id
 * @property int $category_id
 * @property int $sort_id
 * @property int $rank
 * @property bool $isdefault
 *
 * @property Category $category
 *
 * @package Domain\Products\Models\Category
 */
class CategoryProductSortOption extends Model
{
    public $timestamps = false;
    protected $table = 'categories_products_sorts';

    protected $casts = [
        'category_id' => 'int',
        'sort_id' => 'int',
        'rank' => 'int',
        'isdefault' => 'bool',
    ];

    protected $fillable = [
        'category_id',
        'sort_id',
        'rank',
        'isdefault',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sort()
    {
        return $this->belongsTo(ProductSortOption::class, 'sort_id');
    }
}
