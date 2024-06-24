<?php

namespace Domain\Products\Models\Product\OptionTemplates;

use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTemplatesImage
 *
 * @property int $template_id
 * @property int $image_id
 *
 * @property Image $image
 * @property OptionTemplate $options_template
 *
 * @package Domain\Images\Models\OptionsTemplates
 */
class TemplateImage extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'options_templates_images';

    protected $casts = [
        'template_id' => 'int',
        'image_id' => 'int',
    ];

    protected $fillable = [
        'template_id',
        'image_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function template()
    {
        return $this->belongsTo(OptionTemplate::class, 'template_id');
    }
}
