<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\CategoryProductQuery;
use Domain\Products\QueryBuilders\CategoryQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesProductsAssn
 *
 * @property int $category_id
 * @property int $product_id
 * @property bool $manual
 *
 * @property Category $category
 * @property Product $product
 *
 * @package Domain\Products\Models\Category
 */
class CategoryProductShow extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'categories_products_assn';

    protected $casts = [
        'category_id' => 'int',
        'product_id' => 'int',
        'manual' => 'bool',
        'rank' => 'int',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
