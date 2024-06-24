<?php

namespace Domain\Products\Models\Product;

use Domain\Content\Models\Image;
use Domain\Products\QueryBuilders\ProductImageQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class ProductImage extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'products_images';

    protected $casts = [
        'product_id' => 'int',
        'image_id' => 'int',
        'rank' => 'int',
        'show_in_gallery' => 'bool',
    ];

    protected $fillable = [
        'caption',
        'rank',
        'show_in_gallery',
    ];
    public function newEloquentBuilder($query)
    {
        return new ProductImageQuery($query);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
