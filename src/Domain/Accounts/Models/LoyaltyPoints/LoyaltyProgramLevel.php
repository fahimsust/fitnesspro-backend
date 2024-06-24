<?php

namespace Domain\Accounts\Models\LoyaltyPoints;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoyaltypointsLevel
 *
 * @property int $id
 * @property int $loyaltypoints_id
 * @property int $points_per_dollar
 * @property float $value_per_point
 *
 * @property LoyaltyProgram $loyaltypoint
 * @property Collection|array<AvailablePoints> $accounts_loyaltypoints
 * @property Collection|array<PointsCredit> $accounts_loyaltypoints_credits
 * @property Collection|array<PointsDebit> $accounts_loyaltypoints_debits
 * @property Collection|array<LoyaltyProgram> $loyaltypoints
 *
 * @package Domain\Accounts\Models
 */
class LoyaltyProgramLevel extends Model
{
    public $timestamps = false;
    protected $table = 'loyaltypoints_levels';

    protected $casts = [
        'loyaltypoints_id' => 'int',
        'points_per_dollar' => 'int',
        'value_per_point' => 'float',
    ];

    protected $fillable = [
        'loyaltypoints_id',
        'points_per_dollar',
        'value_per_point',
    ];

    public function program()
    {
        return $this->belongsTo(LoyaltyProgram::class, 'loyaltypoints_id');
    }

    public function points()
    {
        return $this->hasMany(AvailablePoints::class);
    }

    public function credits()
    {
        return $this->hasMany(PointsCredit::class);
    }

    public function debits()
    {
        return $this->hasMany(PointsDebit::class);
    }
}
