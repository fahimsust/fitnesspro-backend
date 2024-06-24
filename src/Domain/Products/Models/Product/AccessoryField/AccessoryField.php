<?php

namespace Domain\Products\Models\Product\AccessoryField;

use Domain\Products\Enums\AccessoryFieldTypes;
use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\AccessoryFieldQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AccessoryField extends Model
{
    use HasModelUtilities,
        HasFactory;
    public $timestamps = false;

    protected $table = 'accessories_fields';

    protected $casts = [
        'field_type' => AccessoryFieldTypes::class,
        'required' => 'bool',
        'select_auto' => 'bool',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'label',
        'field_type',
        'required',
        'select_display',
        'select_auto',
        'status',
    ];
    public function newEloquentBuilder($query)
    {
        return new AccessoryFieldQuery($query);
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            AccessoryFieldProduct::class,
            'accessories_fields_id'
        )
            ->withPivot('rank');
    }

//  public function saved_cart_items()
//  {
//      return $this->hasMany(SavedCartItem::class, 'accessory_field_id');
//  }
//
//  public function wishlists_items()
//  {
//      return $this->hasMany(WishlistsItem::class, 'accessory_field_id');
//  }
}
