<?php

namespace Domain\Content\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesCategoriesPage
 *
 * @property int $category_id
 * @property int $page_id
 * @property int $rank
 *
 * @property PageCategory $pages_category
 * @property Page $page
 *
 * @package Domain\Pages\Models
 */
class PagesCategories extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'pages_categories_pages';

    protected $casts = [
        'category_id' => 'int',
        'page_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'category_id',
        'page_id',
        'rank',
    ];

    public function category()
    {
        return $this->belongsTo(PageCategory::class, 'category_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
