<?php

namespace Domain\Sites\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesInventoryRule
 *
 * @property int $site_id
 * @property int $rule_id
 *
 * @property InventoryRule $inventory_rule
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SiteInventoryRule extends Model
{
    use HasFactory,HasModelUtilities;
    public $incrementing = false;
    protected $table = 'sites_inventory_rules';
    protected $primaryKey = 'site_id';

    protected $casts = [
        'site_id' => 'int',
        'rule_id' => 'int',
    ];

    public function rule()
    {
        return $this->belongsTo(InventoryRule::class, 'rule_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
