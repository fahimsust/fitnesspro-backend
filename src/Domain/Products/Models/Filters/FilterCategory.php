<?php

namespace Domain\Products\Models\Filters;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FiltersCategory
 *
 * @property int $filter_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Filter $filter
 *
 * @package Domain\Filters\Models
 */
class FilterCategory extends Model
{
    use HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'filters_categories';

    protected $casts = [
        'filter_id' => 'int',
        'category_id' => 'int',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
