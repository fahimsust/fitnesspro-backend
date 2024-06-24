<?php

namespace Domain\Products\Models\Product;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsSort
 *
 * @property int $id
 * @property string $name
 * @property string $orderby
 * @property string $sortby
 * @property bool $status
 * @property int $rank
 * @property bool $isdefault
 * @property string|null $display
 * @property bool $categories_only
 *
 * @package Domain\Products\Models\Product
 */
class ProductSortOption extends Model
{
    public $timestamps = false;
    protected $table = 'products_sorts';

    protected $casts = [
        'status' => 'bool',
        'rank' => 'int',
        'isdefault' => 'bool',
        'categories_only' => 'bool',
    ];

    protected $fillable = [
        'name',
        'orderby',
        'sortby',
        'status',
        'rank',
        'isdefault',
        'display',
        'categories_only',
    ];
}
