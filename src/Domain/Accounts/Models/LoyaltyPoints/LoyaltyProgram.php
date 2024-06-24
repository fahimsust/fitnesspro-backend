<?php

namespace Domain\Accounts\Models\LoyaltyPoints;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Loyaltypoint
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property int $active_level_id
 *
 * @property LoyaltyProgramLevel $loyaltypoints_level
 * @property Collection|array<Account> $accounts
 * @property Collection|array<AccountType> $accounts_types
 * @property Collection|array<LoyaltyProgramLevel> $loyaltypoints_levels
 *
 * @package Domain\Accounts\Models
 */
class LoyaltyProgram extends Model
{
    public $timestamps = false;
    protected $table = 'loyaltypoints';
    use HasModelUtilities;

    protected $casts = [
        'status' => 'bool',
        'active_level_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'status',
        'active_level_id',
    ];

    public function activeLevel()
    {
        return $this->belongsTo(LoyaltyProgramLevel::class, 'active_level_id');
    }

    public function members()
    {
        return $this->hasMany(Account::class, 'loyaltypoints_id');
    }

    public function accountTypes()
    {
        return $this->hasMany(AccountType::class, 'loyaltypoints_id');
    }

    public function levels()
    {
        return $this->hasMany(LoyaltyProgramLevel::class, 'loyaltypoints_id');
    }
}
