<?php

namespace Domain\Accounts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccountStatus extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'accounts_statuses';

    public function accounts()
    {
        return $this->hasMany(Account::class, 'id', 'status_id');
    }

    public static function activeId(): int
    {
        return self::whereName('Active')
            ->select('id')
            ->first()
            ->id;
    }

    public static function awaitingApprovalId(): int
    {
        return self::whereName('Awaiting Approval')
            ->select('id')
            ->first()
            ->id;
    }
}
