<?php

namespace Domain\Products\Models\Wishlist;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WishlistsItemsOption
 *
 * @property int $wishlists_item_id
 * @property array $options_json
 *
 * @property WishlistItem $wishlists_item
 *
 * @package Domain\Products\Models\Wishlist
 */
class WishlistItemOption extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'wishlists_items_options';
    protected $primaryKey = 'wishlists_item_id';

    protected $casts = [
        'wishlists_item_id' => 'int',
        'options_json' => 'json',
    ];

    protected $fillable = [
        'options_json',
    ];

    public function item()
    {
        return $this->belongsTo(WishlistItem::class);
    }
}
