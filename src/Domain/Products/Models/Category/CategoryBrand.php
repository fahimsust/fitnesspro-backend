<?php

namespace Domain\Products\Models\Category;

use Domain\Products\Models\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesBrand
 *
 * @property int $category_id
 * @property int $brand_id
 *
 * @property Brand $brand
 * @property Category $category
 *
 * @package Domain\Products\Models\Category
 */
class CategoryBrand extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'categories_brands';

    protected $casts = [
        'category_id' => 'int',
        'brand_id' => 'int',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
