<?php

namespace Domain\Products\Models\Wishlist;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WishlistsItemsOptionsCustomvalue
 *
 * @property int $id
 * @property int $wishlists_item_id
 * @property int $option_id
 * @property string $custom_value
 *
 * @property ProductOptionValue $products_options_value
 * @property WishlistItem $wishlists_item
 *
 * @package Domain\Products\Models\Wishlist
 */
class WishlistItemOptionCustomValue extends Model
{
    public $timestamps = false;
    protected $table = 'wishlists_items_options_customvalues';

    protected $casts = [
        'wishlists_item_id' => 'int',
        'option_id' => 'int',
    ];

    protected $fillable = [
        'wishlists_item_id',
        'option_id',
        'custom_value',
    ];

    public function optionValue()
    {
        return $this->belongsTo(ProductOptionValue::class, 'option_id');
    }

    public function item()
    {
        return $this->belongsTo(WishlistItem::class);
    }
}
