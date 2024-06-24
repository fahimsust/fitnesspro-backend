<?php

namespace Domain\Future\GiftCards;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftCard
 *
 * @property int $id
 * @property string $card_code
 * @property Carbon $card_exp
 * @property bool $status
 * @property float $amount
 * @property int $account_id
 * @property string $email
 * @property int $site_id
 *
 * @property Account $account
 * @property Collection|array<GiftCardTransaction> $gift_cards_transactions
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class GiftCard extends Model
{
    public $timestamps = false;
    protected $table = 'gift_cards';

    protected $casts = [
        'status' => 'bool',
        'amount' => 'float',
        'account_id' => 'int',
        'site_id' => 'int',
        'card_exp' => 'datetime',
    ];

    protected $fillable = [
        'card_code',
        'card_exp',
        'status',
        'amount',
        'account_id',
        'email',
        'site_id',
    ];

    public function purchaser()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(GiftCardTransaction::class, 'giftcard_id');
    }

    public function site()
    {
        //TODO fk to sites
        return $this->belongsTo(Site::class, 'site_id');
    }
}
