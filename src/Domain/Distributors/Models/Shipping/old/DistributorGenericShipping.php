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
 * Class DistributorsGenericshipping
 *
 * @property int $distributor_id
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
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorGenericShipping extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_genericshipping';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
//      'state_id' => 'int',
//      'country_id' => 'int'
    ];

    protected $fillable = [
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
        'address_id',
    ];
}
