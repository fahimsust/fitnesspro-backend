<?php

namespace Domain\Products\Models\BookingAs;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Bookinga
 *
 * @property int $id
 * @property string $name
 * @property string $display
 *
 * @property BookingAsOption $bookingas_option
 * @property Collection|array<Product> $products
 *
 * @package Domain\Products\Models\Bookingas
 */
class BookingAs extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;

    protected $table = 'bookingas';

    protected $fillable = [
        'name',
        'display',
    ];

    public function options()
    {
        return $this->hasMany(
            BookingAsOption::class,
            'bookingas_id'
        );
    }

    public function products()
    {
        //todo
        return $this->hasManyThrough(
            Product::class,
            BookingAsProduct::class,
            'bookingas_id',
            'product'
        );
    }
}
