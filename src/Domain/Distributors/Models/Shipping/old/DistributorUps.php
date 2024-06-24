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
 * Class DistributorsUp
 *
 * @property int $distributor_id
 * @property string $account_no
 * @property string $company
 * @property string $phone
 * @property string $email
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property int $state_id
 * @property string $postal_code
 * @property int $country_id
 * @property string $license_number
 * @property string $user_id
 * @property string $password
 * @property bool $label_creation
 *
 * @property Country $country
 * @property Distributor $distributor
 * @property StateProvince $state
 *
 * @package Domain\Distributors\Models
 */
class DistributorUps extends Model
{
    use HasModelUtilities,
        BelongsToAddress,
        BelongsToDistributor;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'distributors_ups';
    protected $primaryKey = 'distributor_id';

    protected $casts = [
        'distributor_id' => 'int',
        'label_creation' => 'bool',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'account_no',
        'license_number',
        'user_id',
        'password',
        'label_creation',
        'address_id',
    ];
}
