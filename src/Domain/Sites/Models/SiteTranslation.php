<?php

namespace Domain\Sites\Models;

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class SiteTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'site_translations';

    public function site():BelongsTo
    {
        return $this->belongsTo(
            Site::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
