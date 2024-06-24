<?php

namespace Domain\Orders\Models\Order;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Models\AdminUser;
use Domain\AdminUsers\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersActivity
 *
 * @property int $order_id
 * @property int $user_id
 * @property string $description
 * @property Carbon $created
 *
 * @property Order $order
 * @property Account $account
 *
 * @package Domain\Orders\Models
 */
class OrderActivity extends Model
{
    use HasModelUtilities, HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'orders_activities';

    protected $casts = [
        'order_id' => 'int',
        'user_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'order_id',
        'user_id',
        'description',
        'created',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
