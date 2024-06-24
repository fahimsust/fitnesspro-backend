<?php

namespace Domain\Products\Models\Product;

use Carbon\Carbon;
use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\QueryBuilders\ProductReviewQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsReview
 *
 * @property int $id
 * @property bool $item_type
 * @property int $item_id
 * @property string $name
 * @property string $comment
 * @property Carbon $created
 * @property float $rating
 * @property bool $approved
 *
 * @property Product $product
 *
 * @package Domain\Products\Models\Product
 */
class ProductReview extends Model
{
    use HasFactory,
        HasModelUtilities;

    public const CREATED_AT = 'created';
    public const UPDATED_AT = null;

    protected $table = 'products_reviews';

    protected $casts = [
        'item_type' => ProductReviewItem::class,
        'item_id' => 'int',
        'rating' => 'float',
        'approved' => 'bool',
        'created' => 'datetime',
    ];
    public function newEloquentBuilder($query)
    {
        return new ProductReviewQuery($query);
    }
    public function getCreatedAttribute($value){
        return Carbon::parse($value)->diffForHumans(['parts'=>2]);
    }

    public function usesTimestamps()
    {
        return true;
    }

    public function item()
    {
        return $this->morphTo();
    }
}
