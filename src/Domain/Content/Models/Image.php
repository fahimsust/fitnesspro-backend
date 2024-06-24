<?php

namespace Domain\Content\Models;

use Domain\Content\QueryBuilders\ImageQuery;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\OptionTemplates\OptionTemplate;
use Domain\Products\Models\Product\OptionTemplates\TemplateOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Support\Traits\HasModelUtilities;

class Image extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $timestamps = false;
    protected $table = 'images';

    protected $fillable = [
        'filename',
        'default_caption',
        'name',
        'inventory_image_id',
    ];

    protected $appends = ['url'];

    public function newEloquentBuilder($query)
    {
        return new ImageQuery($query);
    }

    public function options_templates()
    {
        return $this->belongsToMany(OptionTemplate::class, 'options_templates_images', 'image_id', 'template_id');
    }

    public function options_templates_options_values()
    {
        return $this->hasMany(TemplateOptionValue::class);
    }

    public function products_options_values()
    {
        return $this->hasMany(ProductOptionValue::class);
    }

    public function getUrlAttribute()
    {
        return "https://assets-fitnessprotravel.sfo3.cdn.digitaloceanspaces.com/catalog/images/{$this->filename}";
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            ProductImage::class,
        )->whereStatus(1);
    }
}
