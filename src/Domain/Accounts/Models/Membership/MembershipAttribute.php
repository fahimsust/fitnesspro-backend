<?php

namespace Domain\Accounts\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class MembershipAttribute extends Model
{
    public $timestamps = false;
    protected $table = 'membership_attributes';

    protected $casts = [
        'rank' => 'int',
        'status' => 'bool',
        'section_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'rank',
        'details',
        'status',
        'section_id',
    ];

    public function section()
    {
        return $this->belongsTo(MembershipAttributeSection::class, 'section_id');
    }

    public function levels()
    {
        return $this->hasMany(MembershipLevelAttribute::class, 'attribute_id');
    }
}
