<?php

namespace Domain\Content\Models\Pages;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesSetting
 *
 * @property int $page_id
 * @property int $settings_template_id
 * @property int $module_template_id
 * @property int $layout_id
 * @property string $module_custom_values
 * @property string $module_override_values
 *
 * @property Layout $display_layout
 * @property ModuleTemplate $modules_template
 * @property Page $page
 * @property PageSettingsTemplate $pages_settings_template
 *
 * @package Domain\Pages\Models
 */
class PageSetting extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;
    protected $table = 'pages_settings';
    protected $primaryKey = 'page_id';

    protected $casts = [
        'page_id' => 'int',
        'settings_template_id' => 'int',
        'module_template_id' => 'int',
        'layout_id' => 'int',
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function settingsTemplate()
    {
        return $this->belongsTo(PageSettingsTemplate::class, 'settings_template_id');
    }
}
