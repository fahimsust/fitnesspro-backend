<?php

namespace Domain\System\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class System extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'system';

    protected $casts = [
        'use_cim' => 'bool',
        'charge_action' => 'int',
        'split_charges_by_shipment' => 'bool',
        'auto_archive_completed' => 'bool',
        'auto_archive_canceled' => 'bool',
        'use_fedex' => 'bool',
        'use_ups' => 'bool',
        'use_usps' => 'bool',
        'is_admin_secure' => 'bool',
        'smtp_use' => 'bool',
        'smtp_auth' => 'bool',
        'smtp_secure' => 'int',
        'cart_expiration' => 'int',
        'cart_updateprices' => 'bool',
        'cart_savediscounts' => 'bool',
        'check_for_shipped' => 'bool',
        'check_for_delivered' => 'bool',
        'giftcard_template_id' => 'int',
        'giftcard_waccount_template_id' => 'int',
        'packingslip_showinternalnotes' => 'bool',
        'packingslip_showavail' => 'bool',
        'packingslip_showshipmethod' => 'bool',
        'packingslip_showbillingaddress' => 'bool',
        'ordersummaryemail_showavail' => 'bool',
        'require_agreetoterms' => 'bool',
        'version_updated' => 'datetime',
        'orderplaced_defaultstatus' => 'json',
    ];

    protected $hidden = [
        'smtp_password',
    ];

    protected $fillable = [
        'path',
        'use_cim',
        'charge_action',
        'split_charges_by_shipment',
        'auto_archive_completed',
        'auto_archive_canceled',
        'use_fedex',
        'use_ups',
        'use_usps',
        'catalog_img_url',
        'system_admin_url',
        'system_name',
        'version',
        'version_updated',
        'master_account_pass',
        'is_admin_secure',
        'system_admin_cookie',
        'smtp_use',
        'smtp_host',
        'smtp_auth',
        'smtp_secure',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'cart_expiration',
        'cart_removestatus',
        'cart_updateprices',
        'cart_savediscounts',
        'feature_toggle',
        'check_for_shipped',
        'check_for_delivered',
        'orderplaced_defaultstatus',
        'validate_addresses',
        'giftcard_template_id',
        'giftcard_waccount_template_id',
        'packingslip_showinternalnotes',
        'packingslip_showavail',
        'packingslip_showshipmethod',
        'packingslip_showbillingaddress',
        'ordersummaryemail_showavail',
        'require_agreetoterms',
        'profile_description',
        'timezone',
        'addtocart_external_label',
    ];


    public function orderPlacedDefaultStatus(): array
    {
        return $this->orderplaced_defaultstatus;
    }
}
