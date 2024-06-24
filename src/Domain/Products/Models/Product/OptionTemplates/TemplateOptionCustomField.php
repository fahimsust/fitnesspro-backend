<?php

namespace Domain\Products\Models\Product\OptionTemplates;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTemplatesOptionsCustom
 *
 * @property int $value_id
 * @property bool $custom_type
 * @property int $custom_charlimit
 * @property string $custom_label
 * @property string $custom_instruction
 *
 * @property TemplateOptionValue $options_templates_options_value
 *
 * @package Domain\Images\Models\OptionsTemplates
 */
class TemplateOptionCustomField extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'options_templates_options_custom';
    protected $primaryKey = 'value_id';

    protected $casts = [
        'value_id' => 'int',
        'custom_type' => 'bool',
        'custom_charlimit' => 'int',
    ];

    protected $fillable = [
        'custom_type',
        'custom_charlimit',
        'custom_label',
        'custom_instruction',
    ];

    public function templateOptionValue()
    {
        return $this->belongsTo(TemplateOptionValue::class, 'value_id');
    }
}
