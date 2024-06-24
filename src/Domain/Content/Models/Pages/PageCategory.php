<?php

namespace Domain\Content\Models\Pages;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesCategory
 *
 * @property int $id
 * @property string $name
 * @property string $url_name
 * @property int $parent_category_id
 * @property bool $status
 *
 * @property PageCategory $pages_category
 * @property Collection|array<PageCategory> $pages_categories
 * @property PagesCategories $pages_categories_page
 *
 * @package Domain\Pages\Models
 */
class PageCategory extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'pages_categories';

    protected $casts = [
        'parent_category_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'url_name',
        'parent_category_id',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(PageCategory::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(PageCategory::class, 'parent_category_id');
    }

    public function pages()
    {
        //todo
        return $this->hasManyThrough(
            Page::class,
            PagesCategories::class,
            'category_id'
        );
    }
}
