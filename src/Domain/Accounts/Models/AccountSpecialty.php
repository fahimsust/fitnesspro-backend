<?php

namespace Domain\Accounts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccountSpecialty extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'accounts_specialties';


    public $timestamps = false;

    protected $casts = [
        'approved' => 'boolean',
    ];


    protected $fillable = ['specialty_id', 'account_id', 'approved'];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function scopeApproved($query)
    {
        return $query->whereApproved(1);
    }
}
