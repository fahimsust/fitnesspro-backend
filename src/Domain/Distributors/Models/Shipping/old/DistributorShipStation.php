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
 * Class DistributorsShipstation
 *
 * @property int $distributor_id
 * @property string $api_key
 * @property string $api_secret
 * @property string $company
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property int $state_id
 * @property string $postal_code
 * @property string $contact_name
 * @property int $country_id
 * @property bool $is_residential
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $package_type
 * @property float $default_weight
 * @property int $test
 * @property float $discount
 * @property bool $label_creation
 * @property bool $delivery_confirmation
 * @property bool $insured_mail
 * @property string $storeid
 * @property bool $nondelivery
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorShipStation extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_shipstation';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
//      'state_id' => 'int',
//      'country_id' => 'int',
//      'is_residential' => 'bool',
        'default_weight' => 'float',
        'test' => 'int',
        'discount' => 'float',
        'label_creation' => 'bool',
        'delivery_confirmation' => 'bool',
        'insured_mail' => 'bool',
        'nondelivery' => 'bool',
    ];

    protected $hidden = [
        'api_secret',
    ];

    protected $fillable = [
        'api_key',
        'api_secret',
//      'company',
//      'address_1',
//      'address_2',
//      'city',
//      'state_id',
//      'postal_code',
//      'contact_name',
//      'country_id',
//      'is_residential',
//      'phone',
        'fax',
//      'email',
        'package_type',
        'default_weight',
        'test',
        'discount',
        'label_creation',
        'delivery_confirmation',
        'insured_mail',
        'storeid',
        'nondelivery',
        'address_id',
    ];
}
