<?php

namespace Domain\Sites\Models;

use Domain\Sites\Models\QueryBuilders\InventoryRuleQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class InventoryRule
 *
 * @property int $id
 * @property int $action
 * @property int|null $min_stock_qty
 * @property int|null $max_stock_qty
 * @property int $availabity_changeto
 * @property string $label
 *
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Distributors\Models\Inventory
 */
class InventoryRule extends Model
{
    use HasFactory,HasModelUtilities;
    protected $table = 'inventory_rules';

    protected $casts = [
        'action' => 'bool',
        'min_stock_qty' => 'int',
        'max_stock_qty' => 'int',
        'availabity_changeto' => 'int',
    ];
    public function newEloquentBuilder($query)
    {
        return new InventoryRuleQuery($query);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'sites_inventory_rules', 'rule_id');
    }
}
