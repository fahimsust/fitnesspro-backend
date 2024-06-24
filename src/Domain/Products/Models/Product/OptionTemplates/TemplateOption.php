<?php

namespace Domain\Products\Models\Product\OptionTemplates;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTemplatesOption
 *
 * @property int $id
 * @property string $name
 * @property string $display
 * @property int $type_id
 * @property bool $show_with_thumbnail
 * @property int $rank
 * @property bool $required
 * @property int $template_id
 * @property bool $status
 *
 * @property OptionTemplate $options_template
 * @property Collection|array<TemplateOptionValue> $options_templates_options_values
 *
 * @package Domain\Images\Models\OptionsTemplates
 */
class TemplateOption extends Model
{
    public $timestamps = false;
    protected $table = 'options_templates_options';

    protected $casts = [
        'type_id' => 'int',
        'show_with_thumbnail' => 'bool',
        'rank' => 'int',
        'required' => 'bool',
        'template_id' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'display',
        'type_id',
        'show_with_thumbnail',
        'rank',
        'required',
        'template_id',
        'status',
    ];

    public function template()
    {
        return $this->belongsTo(OptionTemplate::class, 'template_id');
    }

    public function optionValues()
    {
        return $this->hasMany(TemplateOptionValue::class, 'option_id');
    }
}
