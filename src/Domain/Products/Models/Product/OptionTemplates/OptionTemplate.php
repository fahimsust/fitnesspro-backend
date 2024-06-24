<?php

namespace Domain\Products\Models\Product\OptionTemplates;

use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTemplate
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<Image> $images
 * @property Collection|array<TemplateOption> $options_templates_options
 *
 * @package Domain\Images\Models\OptionsTemplates
 */
class OptionTemplate extends Model
{
    public $timestamps = false;
    protected $table = 'options_templates';

    protected $fillable = [
        'name',
    ];

    public function images()
    {
        //todo
        return $this->hasManyThrough(
            Image::class,
            TemplateImage::class,
            'template_id'
        );
    }

    public function options()
    {
        return $this->hasMany(
            TemplateOption::class,
            'template_id'
        );
    }
}
