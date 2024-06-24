<?php

namespace Domain\Accounts\Models\Membership;

use Illuminate\Database\Eloquent\Model;

class MembershipLevelSetting extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'membership_levels_settings';
    protected $primaryKey = 'level_id';

    protected $casts = [
        'level_id' => 'int',
        'badge' => 'int',
        'search_limit' => 'int',
        'event_limit' => 'int',
        'ad_limit' => 'int',
    ];

    protected $fillable = [
        'badge',
        'search_limit',
        'event_limit',
        'ad_limit',
    ];

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class, 'level_id');
    }
}
