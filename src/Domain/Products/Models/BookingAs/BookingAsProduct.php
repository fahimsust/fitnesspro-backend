<?php

namespace Domain\Products\Models\BookingAs;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class BookingasProduct
 *
 * @property int $bookingas_id
 * @property int $product
 *
 * @property BookingAs $bookinga
 *
 * @package Domain\Products\Models\Bookingas
 */
class BookingAsProduct extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'bookingas_products';

    protected $casts = [
        'bookingas_id' => 'int',
        'product' => 'int',
    ];

    protected $fillable = [
        'bookingas_id',
        'product',
    ];

    public function bookingAs()
    {
        return $this->belongsTo(BookingAs::class, 'bookingas_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product');
    }
}
