<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesType
 *
 * @property int $category_id
 * @property int $type_id
 * @property int $id
 *
 * @property Category $category
 * @property ProductType $products_type
 *
 * @package Domain\Products\Models\Category
 */
class CategoryProductType extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'categories_types';

    protected $casts = [
        'category_id' => 'int',
        'type_id' => 'int',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'type_id');
    }
}
