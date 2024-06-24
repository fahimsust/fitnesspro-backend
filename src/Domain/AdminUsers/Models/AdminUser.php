<?php

namespace Domain\AdminUsers\Models;

use Domain\Accounts\Models\Account;
use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class AdminUser
 *
 * @property int $id
 * @property string $user
 * @property string $password
 * @property string $email
 * @property bool $active
 * @property int $level_id
 * @property bool $filter_orders
 * @property string|null $name
 * @property string|null $phone
 * @property int|null $account_id
 *
 * @property Account|null $account
 * @property AdminLevel $admin_level
 * @property Collection|array<Distributor> $distributors
 *
 * @package Domain\AdminUsers\Models
 */
class AdminUser extends Model
{

    use HasModelUtilities;
    public $timestamps = false;
    //todo combine with User model as they're the same
    protected $table = 'admin_users';

    protected $casts = [
        'active' => 'bool',
        'level_id' => 'int',
        'filter_orders' => 'bool',
        'account_id' => 'int',
    ];

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'user',
        'password',
        'email',
        'active',
        'level_id',
        'filter_orders',
        'name',
        'phone',
        'account_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function level()
    {
        return $this->belongsTo(AdminLevel::class, 'level_id');
    }

    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'admin_users_distributors', 'user_id');
    }
}
