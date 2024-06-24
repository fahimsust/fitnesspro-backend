<?php

namespace Domain\Future\GiftCards;

use Carbon\Carbon;
use Domain\AdminUsers\Models\AdminUser;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftCardsTransaction
 *
 * @property int $id
 * @property int $giftcard_id
 * @property float $amount
 * @property bool $action
 * @property string $notes
 * @property int $admin_user_id
 * @property int $order_id
 * @property Carbon $created
 *
 * @property AdminUser $user
 * @property GiftCard $gift_card
 * @property Order $order
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class GiftCardTransaction extends Model
{
    public $timestamps = false;
    protected $table = 'gift_cards_transactions';

    protected $casts = [
        'giftcard_id' => 'int',
        'amount' => 'float',
        'action' => 'bool',
        'admin_user_id' => 'int',
        'order_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'giftcard_id',
        'amount',
        'action',
        'notes',
        'admin_user_id',
        'order_id',
        'created',
    ];

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function card()
    {
        return $this->belongsTo(GiftCard::class, 'giftcard_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
