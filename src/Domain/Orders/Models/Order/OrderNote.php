<?php

namespace Domain\Orders\Models\Order;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Models\AdminUser;
use Domain\AdminUsers\Models\User;
use Domain\Orders\QueryBuilders\OrderNoteQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class OrdersNote
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property string $note
 * @property Carbon $created
 *
 * @property Order $order
 * @property Account $account
 *
 * @package Domain\Orders\Models
 */
class OrderNote extends Model
{
    use HasFactory,
        HasModelUtilities;
    public const CREATED_AT = 'created';

    protected $table = 'orders_notes';

    protected $casts = [
        'order_id' => 'int',
        'user_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'order_id',
        'user_id',
        'note',
        'created',
    ];
    public function newEloquentBuilder($query)
    {
        return new OrderNoteQuery($query);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
