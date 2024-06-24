<?php

namespace Domain\Accounts\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class MembershipLevelAttribute extends Model
{
    public $timestamps = false;
    protected $table = 'membership_levels_attributes';

    protected $casts = [
        'level_id' => 'int',
        'attribute_id' => 'int',
    ];

    protected $fillable = [
        'level_id',
        'attribute_id',
        'attribute_value',
    ];

    public function attribute()
    {
        return $this->belongsTo(MembershipAttribute::class, 'attribute_id');
    }

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class, 'level_id');
    }
}
