<?php

namespace Domain\Content\Models\Faqs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FaqsCategory
 *
 * @property int $id
 * @property int $faqs_id
 * @property int $categories_id
 *
 * @property FaqCategory $faq_category
 * @property Faq $faq
 *
 * @package Domain\Faqs\Models
 */
class FaqsCategories extends Model
{
    use HasFactory, HasModelUtilities;
    public $timestamps = false;
    protected $table = 'faqs_categories';

    protected $casts = [
        'faqs_id' => 'int',
        'categories_id' => 'int',
    ];

    protected $fillable = [
        'faqs_id',
        'categories_id',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'categories_id');
    }

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faqs_id');
    }
}
