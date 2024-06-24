<?php

namespace Domain\Modules\Models;

use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use \Awobaz\Compoships\Compoships;

/**
 * Class ModulesTemplatesSection
 *
 * @property int $template_id
 * @property int $section_id
 * @property int $temp_id
 *
 * @property LayoutSection $display_section
 * @property ModuleTemplate $modules_template
 *
 * @package Domain\Modules\Models
 */
class ModuleTemplateSection extends Model
{
    use HasFactory,
        HasModelUtilities,
        Compoships;

    protected $table = 'modules_templates_sections';

    protected $casts = [
        'template_id' => 'int',
        'section_id' => 'int',
        'temp_id' => 'int',
    ];

    public function modulesTemplatesModules()
    {
        return $this->hasMany(ModuleTemplateModule::class, ['template_id', 'section_id'], ['template_id', 'section_id']);
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
