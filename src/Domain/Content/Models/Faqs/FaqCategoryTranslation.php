<?php

namespace Domain\Content\Models\Faqs;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FaqsCategoriesTranslation
 *
 * @property int $id
 * @property int $categories_id
 * @property int $language_id
 * @property string $title
 *
 * @property FaqCategory $category
 * @property Language $language
 *
 * @package Domain\Faqs\Models
 */
class FaqCategoryTranslation extends Model
{
    use HasFactory, HasModelUtilities;
    public $timestamps = false;
    protected $table = 'faqs_categories_translations';

    protected $casts = [
        'categories_id' => 'int',
        'language_id' => 'int',
    ];

    protected $fillable = [
        'categories_id',
        'language_id',
        'title',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'categories_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
