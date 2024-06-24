<?php

namespace Domain\Content\Models\Faqs;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FaqsTranslation
 *
 * @property int $id
 * @property int $faqs_id
 * @property int $language_id
 * @property string $question
 * @property string $answer
 *
 * @property Faq $faq
 * @property Language $language
 *
 * @package Domain\Faqs\Models
 */
class FaqTranslation extends Model
{
    use HasFactory, HasModelUtilities;
    public $timestamps = false;
    protected $table = 'faqs_translations';

    protected $casts = [
        'faqs_id' => 'int',
        'language_id' => 'int',
    ];

    protected $fillable = [
        'faqs_id',
        'language_id',
        'question',
        'answer',
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'faqs_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
