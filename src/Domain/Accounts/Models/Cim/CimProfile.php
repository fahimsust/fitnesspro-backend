<?php

namespace Domain\Accounts\Models\Cim;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountCim;
use Domain\Payments\Models\PaymentAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class CimProfile extends Model
{
    use HasModelUtilities,
        HasFactory;

    public $timestamps = false;
    protected $table = 'cim_profile';

    protected $casts = [
        'gateway_account_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'authnet_profile_id',
        'gateway_account_id',
    ];

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'gateway_account_id');
    }

    //todo (maybe) once account_id is moved here, can use this
//  public function owner()
//  {
//      return $this->belongsTo(Account::class);
//  }

    public function accounts()
    {
        //todo
        return $this->hasManyThrough(
            Account::class,
            AccountCim::class
        );
    }

    public function paymentProfiles()
    {
        return $this->hasMany(CimPaymentProfile::class, 'profile_id');
    }
}
