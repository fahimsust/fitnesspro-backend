<?php

namespace Domain\Accounts\Models;

use Domain\Accounts\Models\Cim\CimProfile;
use Illuminate\Database\Eloquent\Model;

class AccountCim extends Model
{
    public $timestamps = false;
    //todo (maybe) refactor to have account_id on cim_profile table
    //each cim profile is specific to an account, so we don't need this pivot table
    protected $table = 'accounts_cims';

    protected $casts = [
        'account_id' => 'int',
        'cim_profile_id' => 'int',
    ];

    protected $fillable = [
        'account_id',
        'cim_profile_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Account::class);
    }

    public function profile()
    {
        return $this->belongsTo(CimProfile::class);
    }
}
