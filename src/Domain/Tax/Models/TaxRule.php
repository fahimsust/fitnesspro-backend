<?php

namespace Domain\Tax\Models;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class TaxRule
 *
 * @property int $id
 * @property string $name
 * @property float $rate
 * @property bool $type
 *
 * @property Collection|array<Site> $sites
 * @property Collection|array<TaxRuleLocation> $tax_rules_locations
 * @property Collection|array<TaxRuleProductType> $tax_rules_product_types
 *
 * @package Domain\Tax\Models
 */
class TaxRule extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'tax_rules';

    protected $casts = [
        'rate' => 'int',
        'type' => 'bool',
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'sites_tax_rules');
    }

    public function locations()
    {
        return $this->hasMany(TaxRuleLocation::class);
    }

    public function productTypes()
    {
        return $this->hasMany(TaxRuleProductType::class);
    }
}
