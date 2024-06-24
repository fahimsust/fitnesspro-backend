<?php

namespace Domain\Content\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class ElementTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'element_translations';

    public function element():BelongsTo
    {
        return $this->belongsTo(
            Element::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
