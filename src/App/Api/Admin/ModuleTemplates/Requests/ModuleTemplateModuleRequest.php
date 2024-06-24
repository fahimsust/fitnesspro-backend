<?php

namespace App\Api\Admin\ModuleTemplates\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ModuleTemplateModuleRequest extends FormRequest
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
            'template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'required'],
            'section_id' => ['numeric', 'exists:' . LayoutSection::Table() . ',id', 'required'],
            'module_id' => ['numeric', 'exists:' . Module::Table() . ',id', 'required', new IsCompositeUnique(
                ModuleTemplateModule::Table(),
                [
                    'template_id' => $this->template_id,
                    'section_id' => $this->section_id,
                    'module_id' => $this->module_id,
                ],
                $this->id
            ),],
        ];
    }
}
