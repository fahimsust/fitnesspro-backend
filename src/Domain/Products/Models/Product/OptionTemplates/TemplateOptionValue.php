<?php

namespace Domain\Products\Models\Product\OptionTemplates;

use Carbon\Carbon;
use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTemplatesOptionsValue
 *
 * @property int $id
 * @property int $option_id
 * @property string $name
 * @property string $display
 * @property float $price
 * @property int $rank
 * @property int $image_id
 * @property bool $is_custom
 * @property bool $status
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 *
 * @property Image $image
 * @property TemplateOption $options_templates_option
 * @property TemplateOptionCustomField $options_templates_options_custom
 *
 * @package Domain\Images\Models\OptionsTemplates
 */
class TemplateOptionValue extends Model
{
    public $timestamps = false;
    protected $table = 'options_templates_options_values';

    protected $casts = [
        'option_id' => 'int',
        'price' => 'float',
        'rank' => 'int',
        'image_id' => 'int',
        'is_custom' => 'bool',
        'status' => 'bool',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'option_id',
        'name',
        'display',
        'price',
        'rank',
        'image_id',
        'is_custom',
        'status',
        'start_date',
        'end_date',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function templateOption()
    {
        return $this->belongsTo(TemplateOption::class, 'option_id');
    }

    public function templateOptionCustomField()
    {
        return $this->hasOne(TemplateOptionCustomField::class, 'value_id');
    }
}
