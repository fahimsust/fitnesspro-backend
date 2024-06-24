<?php

namespace Domain\Sites\Models;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesCategory
 *
 * @property int $site_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SiteCategory extends Model
{
    use HasFactory,HasModelUtilities;
    public $incrementing = false;
    protected $table = 'sites_categories';

    protected $casts = [
        'site_id' => 'int',
        'category_id' => 'int',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
