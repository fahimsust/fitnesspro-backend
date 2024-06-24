<?php

namespace Domain\Future\GiftRegistry;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Models\Gender;

/**
 * Class Giftregistry
 *
 * @property int $id
 * @property int $account_id
 * @property string $registry_name
 * @property int $registry_type
 * @property string $event_name
 * @property Carbon $event_date
 * @property bool $public_private
 * @property string $private_key
 * @property Carbon $created
 * @property Carbon $modified
 * @property bool $status
 * @property int $shipto_id
 * @property string $notes_to_friends
 * @property string $registrant_name
 * @property string $coregistrant_name
 * @property Carbon $baby_duedate
 * @property bool $baby_gender
 * @property string $baby_name
 * @property bool $baby_firstchild
 *
 * @property Account $account
 * @property AccountAddress $accounts_addressbook
 * @property Collection|array<RegistryItem> $giftregistry_items
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class GiftRegistry extends Model
{
    public $timestamps = false;
    protected $table = 'giftregistry';

    protected $casts = [
        'account_id' => 'int',
        'registry_type' => 'int',
        'public_private' => 'bool',
        'status' => 'bool',
        'shipto_id' => 'int',
        'baby_gender' => 'bool',
        'baby_firstchild' => 'bool',
        'event_date' => 'datetime',
        'created' => 'datetime',
        'modified' => 'datetime',
        'baby_duedate' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'registry_name',
        'registry_type',
        'event_name',
        'event_date',
        'public_private',
        'private_key',
        'created',
        'modified',
        'status',
        'shipto_id',
        'notes_to_friends',
        'registrant_name',
        'coregistrant_name',
        'baby_duedate',
        'baby_gender',
        'baby_name',
        'baby_firstchild',
    ];

    //move gift registry to own domain

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function shipToAddress(): BelongsTo
    {
        return $this->belongsTo(AccountAddress::class, 'shipto_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RegistryItem::class, 'registry_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'baby_gender');
    }
}
