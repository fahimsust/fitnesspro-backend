<?php

namespace Domain\Content\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LanguagesTranslation
 *
 * @property int $id
 * @property int $content_id
 * @property int $language_id
 * @property string $msgstr
 * @property bool $status
 *
 * @property LanguageContent $languages_content
 * @property Language $language
 *
 * @package Domain\Language\Models
 */
class LanguageTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'languages_translations';

    protected $casts = [
        'content_id' => 'int',
        'language_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'content_id',
        'language_id',
        'msgstr',
        'status',
    ];

    public function content()
    {
        return $this->belongsTo(LanguageContent::class, 'content_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
