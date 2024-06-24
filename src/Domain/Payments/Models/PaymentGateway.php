<?php

/**
 * Created by Reliese Model.
 */

namespace Domain\Payments\Models;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Distributors\Models\Inventory\GatewayField;
use Domain\Distributors\Models\Inventory\InventoryAccount;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PaymentGateway
 *
 * @property int $id
 * @property string $name
 * @property string $template
 * @property bool $is_creditcard
 * @property string $classname
 *
 * @property SubscriptionPaymentOption $accounts_memberships_payment_method
 * @property Collection|array<InventoryAccount> $inventory_gateways_accounts
 * @property Collection|array<GatewayField> $inventory_gateways_fields
 * @property Collection|array<OrderTransaction> $orders_transactions
 * @property Collection|array<PaymentAccount> $payment_gateways_accounts
 * @property Collection|array<PaymentMethod> $payment_methods
 *
 * @package Domain\Payments\Models
 */
class PaymentGateway extends Model
{
    use HasModelUtilities,
        HasFactory;
    public $timestamps = false;

    protected $table = 'payment_gateways';

    protected $casts = [
        'is_creditcard' => 'bool',
    ];

    protected $fillable = [
        'name',
        'template',
        'is_creditcard',
        'classname',
    ];

    public function inventoryAccounts()
    {
        return $this->hasMany(InventoryAccount::class, 'gateway_id');
    }

    public function gatewayFields()
    {
        return $this->hasMany(GatewayField::class, 'gateway_id');
    }

    public function orderTransactions()
    {
        return $this->hasMany(OrderTransaction::class, 'gateway_account_id');
    }

    public function paymentAccounts()
    {
        return $this->hasMany(PaymentAccount::class, 'gateway_id');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'gateway_id');
    }
}
