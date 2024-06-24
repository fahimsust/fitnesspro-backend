<?php

namespace Domain\Discounts\Models\Level;

use Domain\Accounts\Models\AccountType;
use Domain\Discounts\Enums\DiscountLevelActionType;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DiscountsLevel
 *
 * @property int $id
 * @property string $name
 * @property int $apply_to
 * @property bool $action_type
 * @property float $action_percentage
 * @property int $action_sitepricing
 * @property bool $status
 *
 * @property Collection|array<AccountType> $accounts_types
 * @property Collection|array<Product> $products
 *
 * @package Domain\Orders\Models\Discount
 */
class DiscountLevel extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;
    protected $table = 'discounts_levels';
    protected $appends = ['level_type'];

    protected $casts = [
        'apply_to' => 'int',
        'action_type' => 'int',
        'action_percentage' => 'float',
        'action_sitepricing' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'apply_to',
        'action_type',
        'action_percentage',
        'action_sitepricing',
        'status',
    ];

    public function getLevelTypeAttribute(): array
    {
        return
            [
                'id' => $this->attributes['action_type'],
                'name' => DiscountLevelActionType::from($this->attributes['action_type'])->label()
            ];
    }
    public function accountTypes()
    {
        return $this->hasMany(AccountType::class, 'discount_level_id');
    }
    public function discountLevelProducts()
    {
        return $this->hasMany(DiscountLevelProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            DiscountLevelProduct::class,
            'discount_level_id'
        )
            ->withPivot('id');
    }
}
