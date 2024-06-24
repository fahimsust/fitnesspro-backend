<?php

namespace Domain\Orders\Models\Checkout;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Orders\Models\Carts\Cart;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SavedOrder
 *
 * @property int $id
 * @property string $unique_id
 * @property int $account_id
 * @property int $saved_cart_id
 * @property Carbon $created
 * @property int $site_id
 * @property bool $status
 *
 * @property Account $account
 * @property Cart $saved_cart
 * @property Site $site
 *
 * @package Domain\Orders\Models\SavedOrders
 */
class SavedOrder extends Model
{
    public $timestamps = false;
    protected $table = 'saved_order';

    protected $casts = [
        'account_id' => 'int',
        'saved_cart_id' => 'int',
        'site_id' => 'int',
        'status' => 'bool',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'unique_id',
        'account_id',
        'saved_cart_id',
        'created',
        'site_id',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
