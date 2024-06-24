<?php

namespace Domain\Content\Models\Faqs;

use Domain\Content\QueryBuilders\FaqQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Faq
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property bool $status
 * @property int $rank
 * @property string $url
 *
 * @property Collection|array<FaqsCategories> $faqs_categories
 * @property Collection|array<FaqTranslation> $faqs_translations
 * @property Collection|array<FaqCategory> $categories
 *
 * @package Domain\Faqs\Models
 */
class Faq extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;
    protected $table = 'faqs';

    protected $casts = [
        'status' => 'bool',
        'rank' => 'int',
    ];

    protected $fillable = [
        'question',
        'answer',
        'status',
        'rank',
        'url',
    ];
    public function newEloquentBuilder($query)
    {
        return new FaqQuery($query);
    }

    public function faq_categories()
    {
        return $this->hasMany(FaqsCategories::class, 'faqs_id');
    }
    public function categories()
    {
        return $this->belongsToMany(
            FaqCategory::class,
            FaqsCategories::class,
            'faqs_id',
            'categories_id'
        );
    }

    public function translations()
    {
        return $this->hasMany(FaqTranslation::class, 'faqs_id');
    }
}
