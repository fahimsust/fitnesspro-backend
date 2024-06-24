<?php

namespace Domain\Products\Models\Wishlist;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wishlist
 *
 * @property int $id
 * @property int $account_id
 * @property Carbon $created
 *
 * @property Account $account
 * @property Collection|array<WishlistItem> $wishlists_items
 *
 * @package Domain\Products\Models\Wishlist
 */
class Wishlist extends Model
{
    public $timestamps = false;
    protected $table = 'wishlists';

    protected $casts = [
        'account_id' => 'int',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'created',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function items()
    {
        return $this->hasMany(WishlistItem::class);
    }
}
