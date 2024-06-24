<?php

namespace Domain\Products\Models\Wishlist;

use Carbon\Carbon;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WishlistsItem
 *
 * @property int $id
 * @property int $wishlist_id
 * @property int $product_id
 * @property int $parent_product
 * @property Carbon $added
 * @property int $parent_wishlist_items_id
 * @property bool $is_accessory
 * @property bool $accessory_required
 * @property int $accessory_field_id
 * @property bool $notify_backinstock
 * @property Carbon $notify_backinstock_attempted
 *
 * @property AccessoryField $accessories_field
 * @property Product $product
 * @property WishlistItem $wishlists_item
 * @property Wishlist $wishlist
 * @property Collection|array<WishlistItem> $wishlists_items
 * @property Collection|array<WishlistItemCustomField> $wishlists_items_customfields
 * @property WishlistItemOption $wishlists_items_option
 * @property Collection|array<WishlistItemOptionCustomValue> $wishlists_items_options_customvalues
 *
 * @package Domain\Products\Models\Wishlist
 */
class WishlistItem extends Model
{
    public $timestamps = false;
    protected $table = 'wishlists_items';

    protected $casts = [
        'wishlist_id' => 'int',
        'product_id' => 'int',
        'parent_product' => 'int',
        'parent_wishlist_items_id' => 'int',
        'is_accessory' => 'bool',
        'accessory_required' => 'bool',
        'accessory_field_id' => 'int',
        'notify_backinstock' => 'bool',
        'added' => 'datetime',
        'notify_backinstock_attempted' => 'datetime',
    ];

    protected $fillable = [
        'wishlist_id',
        'product_id',
        'parent_product',
        'added',
        'parent_wishlist_items_id',
        'is_accessory',
        'accessory_required',
        'accessory_field_id',
        'notify_backinstock',
        'notify_backinstock_attempted',
    ];

    public function accessoryField()
    {
        return $this->belongsTo(AccessoryField::class, 'accessory_field_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(WishlistItem::class, 'parent_wishlist_items_id');
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function siblings()
    {
        return $this->hasMany(
            WishlistItem::class,
            'parent_wishlist_items_id',
            'parent_wishlist_items_id'
        );
    }

    public function customFields()
    {
        return $this->hasMany(
            WishlistItemCustomField::class
        );
    }

    public function option()
    {
        return $this->hasOne(
            WishlistItemOption::class
        );
    }

    public function optionCustomValues()
    {
        return $this->hasMany(
            WishlistItemOptionCustomValue::class
        );
    }
}
