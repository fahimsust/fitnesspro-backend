<?php

namespace Domain\Content\Models\Pages;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class PageTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'page_translations';

    public function page():BelongsTo
    {
        return $this->belongsTo(
            Page::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
