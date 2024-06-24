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
 * Class DistributorsCanadapost
 *
 * @property int $distributor_id
 * @property string $username
 * @property string $customer_number
 * @property string $contract_id
 * @property string $password
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
 * @property bool $quote_type
 * @property string $promo_code
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorCanadaPost extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_canadapost';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
//      'state_id' => 'int',
//      'country_id' => 'int',
        'default_weight' => 'float',
        'test' => 'int',
        'discount' => 'float',
        'label_creation' => 'bool',
        'quote_type' => 'bool',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'username',
        'customer_number',
        'contract_id',
        'password',
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
        'quote_type',
        'promo_code',
        'address_id',
    ];
}
