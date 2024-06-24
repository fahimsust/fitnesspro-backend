<?php

namespace Domain\Products\Models\Category;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class CategoryTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'category_translations';

    public function category():BelongsTo
    {
        return $this->belongsTo(
            Category::class
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
