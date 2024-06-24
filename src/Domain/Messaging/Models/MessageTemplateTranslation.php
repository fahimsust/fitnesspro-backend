<?php

namespace Domain\Messaging\Models;

use Domain\Locales\Models\Language;
use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class MessageTemplateTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'message_template_translations';

    public function messageTemplate(): BelongsTo
    {
        return $this->belongsTo(
            MessageTemplate::class
        );
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
