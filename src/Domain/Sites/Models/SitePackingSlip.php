<?php

namespace Domain\Sites\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesPackingslip
 *
 * @property int $site_id
 * @property int $packingslip_appendix_elementid
 * @property bool $packingslip_showlogo
 *
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SitePackingSlip extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'sites_packingslip';
    protected $primaryKey = 'site_id';

    protected $casts = [
        'site_id' => 'int',
        'packingslip_appendix_elementid' => 'int',
        'packingslip_showlogo' => 'bool',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function element()
    {
        return $this->belongsTo(Element::class, 'packingslip_appendix_elementid');
    }
}
