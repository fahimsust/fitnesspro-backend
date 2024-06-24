<?php

namespace Domain\Content\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LanguagesContent
 *
 * @property int $id
 * @property string $msgid
 * @property bool $status
 *
 * @property Collection|array<LanguageTranslation> $languages_translations
 *
 * @package Domain\Language\Models
 */
class LanguageContent extends Model
{
    public $timestamps = false;
    protected $table = 'languages_content';

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'msgid',
        'status',
    ];

    public function translations()
    {
        return $this->hasMany(LanguageTranslation::class, 'content_id');
    }
}
