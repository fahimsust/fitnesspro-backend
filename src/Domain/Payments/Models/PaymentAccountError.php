<?php

namespace Domain\Payments\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentGatewaysError
 *
 * @property Carbon $created
 * @property string $response
 * @property int $gateway_account_id
 *
 * @property PaymentAccount $payment_gateways_account
 *
 * @package Domain\Payments\Models
 */
class PaymentAccountError extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'payment_gateways_errors';

    protected $casts = [
        'gateway_account_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'created',
        'response',
        'gateway_account_id',
    ];

    public function paymentAccount()
    {
        return $this->belongsTo(
            PaymentAccount::class,
            'gateway_account_id'
        );
    }
}
