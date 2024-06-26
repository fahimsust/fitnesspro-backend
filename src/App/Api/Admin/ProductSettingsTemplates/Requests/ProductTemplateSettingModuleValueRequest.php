<?php

namespace App\Api\Admin\ProductSettingsTemplates\Requests;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductTemplateSettingModuleValueRequest extends FormRequest
{
    use HasFactory;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'settings_template_id' => [
                'int',
                'exists:' . ProductSettingsTemplate::Table() . ',id',
                'required',
            ],
            'module_id' => [
                'int',
                'exists:' . Module::Table() . ',id',
                'required',
            ],
            'field_id' => [
                'int',
                'exists:' . ModuleField::Table() . ',id',
                'required',
            ],
            'section_id' => [
                'int',
                'exists:' . LayoutSection::Table() . ',id',
                'required',
            ],
            'custom_value' => [
                'string',
                'nullable',
            ],

        ];
    }
}
