<?php

namespace Domain\Locales\Models;

use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Domain\Content\Models\Faqs\FaqTranslation;
use Domain\Content\Models\LanguageTranslation;
use Domain\Locales\Models\QueryBuilders\LanguageQuery;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Language
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property bool $status
 *
 * @property Collection|array<FaqCategoryTranslation> $faqs_categories_translations
 * @property Collection|array<FaqTranslation> $faqs_translations
 * @property Collection|array<LanguageTranslation> $languages_translations
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Language\Models
 */
class Language extends Model
{
    use HasFactory,
    HasModelUtilities;
    protected $table = 'languages';

    public function newEloquentBuilder($query)
    {
        return new LanguageQuery($query);
    }

    protected $casts = [
        'status' => 'bool',
    ];
}
