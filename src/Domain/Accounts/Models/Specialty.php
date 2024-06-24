<?php

namespace Domain\Accounts\Models;

use Domain\Accounts\QueryBuilders\SpecialityQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

class Specialty extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'specialties';

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Specialty::class, 'parent_id');
    }
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
    public function accountSpecialties()
    {
        return $this->hasMany(AccountSpecialty::class);
    }
    public function getAccountSpecialty($accountId)
    {
        $accountSpecialty = $this->accountSpecialties()
            ->where('account_id', $accountId)
            ->first();

        return [
            'exists' => !!$accountSpecialty,
            'id' => $accountSpecialty ? $accountSpecialty->id : 0,
            'approved' => optional($accountSpecialty)->approved ?? false
        ];
    }

    public function accounts()
    {
        //TODO test
        return $this->hasManyThrough(
            Account::class,
            AccountSpecialty::class,
        );
    }
    public function newEloquentBuilder($query)
    {
        return new SpecialityQuery($query);
    }
}
