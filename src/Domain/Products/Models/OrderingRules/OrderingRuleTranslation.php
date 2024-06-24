<?php

namespace Domain\Products\Models\OrderingRules;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;


class OrderingRuleTranslation extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'ordering_rule_translations';

    public function orderingRule():BelongsTo
    {
        return $this->belongsTo(
            OrderingRule::class,
            'rule_id'
        );
    }
    public function language():BelongsTo
    {
        return $this->belongsTo(
            Language::class
        );
    }
}
