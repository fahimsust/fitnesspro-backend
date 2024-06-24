<?php

namespace Domain\Modules\Models;

use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use \Awobaz\Compoships\Compoships;

/**
 * Class ModulesTemplatesModule
 *
 * @property int $template_id
 * @property int $section_id
 * @property int $module_id
 * @property int $rank
 * @property int $temp_id
 *
 * @property Module $module
 * @property LayoutSection $display_section
 * @property ModuleTemplate $modules_template
 *
 * @package Domain\Modules\Models
 */
class ModuleTemplateModule extends Model
{
    use HasFactory,
        HasModelUtilities,
        Compoships;

    protected $table = 'modules_templates_modules';

    protected $casts = [
        'template_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'rank' => 'int',
        'temp_id' => 'int',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function layoutSection()
    {
        return $this->belongsTo(LayoutSection::class, 'section_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'template_id');
    }
}
