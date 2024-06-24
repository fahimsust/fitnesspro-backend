<?php

namespace Domain\Sites\Models;

use Domain\Tax\Models\TaxRule;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SitesTaxRule
 *
 * @property int $site_id
 * @property int $tax_rule_id
 *
 * @property Site $site
 * @property TaxRule $tax_rule
 *
 * @package Domain\Sites\Models
 */
class SiteTaxRule extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'sites_tax_rules';

    protected $casts = [
        'site_id' => 'int',
        'tax_rule_id' => 'int',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function taxRule()
    {
        return $this->belongsTo(TaxRule::class);
    }
}
