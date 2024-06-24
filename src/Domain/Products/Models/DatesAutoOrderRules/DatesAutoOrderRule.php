<?php

namespace Domain\Products\Models\DatesAutoOrderRules;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ModsDatesAutoOrderrule
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 *
 * @property Collection|array<DatesAutoOrderRuleAction> $mods_dates_auto_orderrules_actions
 * @property Collection|array<DatesAutoOrderRuleExclude> $mods_dates_auto_orderrules_excludes
 * @property Collection|array<Product> $products
 *
 * @package Domain\Products\Models\Mods
 */
class DatesAutoOrderRule extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'dates_auto_orderrules';

    protected $casts = [
        'status' => 'bool',
    ];

    public function actions()
    {
        return $this->hasMany(
            DatesAutoOrderRuleAction::class,
            'dao_id'
        );
    }

    public function excludes()
    {
        return $this->hasMany(
            DatesAutoOrderRuleExclude::class,
            'dao_id'
        );
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            DatesAutoOrderRuleInclude::class,
            'dao_id'
        )
            ->withPivot('id');
    }
}
