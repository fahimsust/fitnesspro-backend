<?php

namespace Domain\Accounts\Models\Cim;

use Carbon\Carbon;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\HasModelUtilities;

/**
 * Class CimProfilePaymentprofile
 *
 * @property int $id
 * @property int $profile_id
 * @property int $first_cc_number
 * @property string $cc_number
 * @property Carbon $cc_exp
 * @property string $zipcode
 * @property string $authnet_payment_profile_id
 * @property bool $is_default
 *
 * @property CimProfile $cim_profile
 * @property Collection|array<OrderTransaction> $orders_transactions
 *
 * @package Domain\Accounts\Models
 */
class CimPaymentProfile extends Model
{
    use HasModelUtilities,
        HasFactory;

    public $timestamps = false;
    protected $table = 'cim_profile_paymentprofile';

    protected $casts = [
        'profile_id' => 'int',
        'first_cc_number' => 'int',
        'is_default' => 'bool',
        'cc_exp' => 'datetime',
    ];

    protected $fillable = [
        'profile_id',
        'first_cc_number',
        'cc_number',
        'cc_exp',
        'zipcode',
        'authnet_payment_profile_id',
        'is_default',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (CimPaymentProfile $profile) {
            $profile->clearCaches();
        });

        static::deleted(function (CimPaymentProfile $profile) {
            $profile->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags([
            'cim-payment-profile-cache.' . $this->id,
        ])->flush();
    }

    public function profile()
    {
        return $this->belongsTo(CimProfile::class, 'profile_id');
    }

    public function ordersUsedFor()
    {
        return $this->hasMany(OrderTransaction::class, 'cim_payment_profile_id');
    }

    public function expiration(): string
    {
        return $this->cc_exp;
    }
}
