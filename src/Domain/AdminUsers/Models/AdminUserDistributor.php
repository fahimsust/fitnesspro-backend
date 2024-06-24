<?php

namespace Domain\AdminUsers\Models;

use Domain\Distributors\Models\Distributor;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminUsersDistributor
 *
 * @property int $user_id
 * @property int $distributor_id
 *
 * @property Distributor $distributor
 * @property AdminUser $admin_user
 *
 * @package Domain\AdminUsers\Models
 */
class AdminUserDistributor extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'admin_users_distributors';

    protected $casts = [
        'user_id' => 'int',
        'distributor_id' => 'int',
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id');
    }
}
