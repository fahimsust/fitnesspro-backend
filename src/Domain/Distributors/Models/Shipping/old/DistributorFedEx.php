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
 * Class DistributorsFedex
 *
 * @property int $distributor_id
 * @property string $accountno
 * @property string $meterno
 * @property string $keyword
 * @property string $pass
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
 * @property bool $rate_type
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorFedEx extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_fedex';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
//      'state_id' => 'int',
//      'country_id' => 'int',
        'default_weight' => 'float',
        'test' => 'int',
        'discount' => 'float',
        'label_creation' => 'bool',
        'rate_type' => 'bool',
    ];

    protected $fillable = [
        'accountno',
        'meterno',
        'keyword',
        'pass',
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
        'rate_type',
        'address_id',
    ];
}
