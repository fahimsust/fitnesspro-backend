<?php

namespace Domain\Accounts\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class MembershipAttributeSection extends Model
{
    public $timestamps = false;
    protected $table = 'membership_attributes_sections';

    protected $casts = [
        'rank' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'rank',
        'status',
    ];

    public function attributes()
    {
        return $this->hasMany(MembershipAttribute::class, 'section_id');
    }
}
