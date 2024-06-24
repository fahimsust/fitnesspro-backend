<?php

namespace Domain\Content\Models\Faqs;

use Domain\Content\QueryBuilders\FaqCategoryQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FaqCategory
 *
 * @property int $id
 * @property string $title
 * @property bool $status
 * @property int $rank
 * @property string $url
 *
 * @property Collection|array<FaqsCategories> $faqs_categories
 * @property Collection|array<FaqCategoryTranslation> $faqs_categories_translations
 *
 * @package Domain\Faqs\Models
 */
class FaqCategory extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;
    protected $table = 'faq_categories';

    protected $casts = [
        'status' => 'bool',
        'rank' => 'int',
    ];

    protected $fillable = [
        'title',
        'status',
        'rank',
        'url',
    ];
    public function newEloquentBuilder($query)
    {
        return new FaqCategoryQuery($query);
    }

    public function faqs()
    {
        return $this->belongsToMany(
            Faq::class,
            FaqsCategories::class,
            'categories_id',
            'faqs_id'
        );
    }
    public function faq_categories()
    {
        return $this->hasMany(FaqsCategories::class, 'categories_id');
    }

    public function translations()
    {
        return $this->hasMany(FaqCategoryTranslation::class, 'categories_id');
    }
}
