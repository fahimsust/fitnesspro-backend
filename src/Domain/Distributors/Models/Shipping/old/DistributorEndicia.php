<?php

namespace Domain\Distributors\Models\Shipping\old;

use Domain\Addresses\Traits\BelongsToAddress;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Locales\Models\StateProvince;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\BelongsTo\BelongsToDistributor;
use Support\Traits\HasModelUtilities;

/**
 * Class DistributorsEndicium
 *
 * @property int $distributor_id
 * @property string $requester_id
 * @property string $account_id
 * @property string $pass_phrase
 * @property string $company
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property int $state_id
 * @property string $postal_code
 * @property string $contact_name
 * @property int $country_id
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $package_type
 * @property float $default_weight
 * @property int $test
 * @property float $discount
 * @property bool $label_creation
 * @property int $default_label_size
 * @property bool $default_label_rotate
 * @property int $destconfirm_label_size
 * @property bool $destconfirm_label_rotate
 * @property int $certified_label_size
 * @property bool $certified_label_rotate
 * @property int $international_label_size
 * @property bool $international_label_rotate
 * @property bool $rate_type
 * @property bool $display_postage
 * @property bool $display_postdate
 * @property bool $delivery_confirmation
 * @property bool $signature_confirmation
 * @property bool $certified_mail
 * @property bool $restricted_delivery
 * @property bool $return_receipt
 * @property bool $electronic_return_receipt
 * @property bool $hold_for_pickup
 * @property bool $open_and_distribute
 * @property bool $cod
 * @property bool $insured_mail
 * @property bool $adult_signature
 * @property bool $registered_mail
 * @property bool $am_delivery
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorEndicia extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_endicia';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
//      'state_id' => 'int',
//      'country_id' => 'int',
        'default_weight' => 'float',
        'test' => 'int',
        'discount' => 'float',
        'label_creation' => 'bool',
        'default_label_size' => 'int',
        'default_label_rotate' => 'bool',
        'destconfirm_label_size' => 'int',
        'destconfirm_label_rotate' => 'bool',
        'certified_label_size' => 'int',
        'certified_label_rotate' => 'bool',
        'international_label_size' => 'int',
        'international_label_rotate' => 'bool',
        'rate_type' => 'bool',
        'display_postage' => 'bool',
        'display_postdate' => 'bool',
        'delivery_confirmation' => 'bool',
        'signature_confirmation' => 'bool',
        'certified_mail' => 'bool',
        'restricted_delivery' => 'bool',
        'return_receipt' => 'bool',
        'electronic_return_receipt' => 'bool',
        'hold_for_pickup' => 'bool',
        'open_and_distribute' => 'bool',
        'cod' => 'bool',
        'insured_mail' => 'bool',
        'adult_signature' => 'bool',
        'registered_mail' => 'bool',
        'am_delivery' => 'bool',
    ];

    protected $fillable = [
        'requester_id',
        'account_id',
        'pass_phrase',
//      'company',
//      'address_1',
//      'address_2',
//      'city',
//      'state_id',
//      'postal_code',
        'contact_name',
//      'country_id',
//      'phone',
        'fax',
//      'email',
        'package_type',
        'default_weight',
        'test',
        'discount',
        'label_creation',
        'default_label_size',
        'default_label_rotate',
        'destconfirm_label_size',
        'destconfirm_label_rotate',
        'certified_label_size',
        'certified_label_rotate',
        'international_label_size',
        'international_label_rotate',
        'rate_type',
        'display_postage',
        'display_postdate',
        'delivery_confirmation',
        'signature_confirmation',
        'certified_mail',
        'restricted_delivery',
        'return_receipt',
        'electronic_return_receipt',
        'hold_for_pickup',
        'open_and_distribute',
        'cod',
        'insured_mail',
        'adult_signature',
        'registered_mail',
        'am_delivery',
        'address_id',
    ];
}
