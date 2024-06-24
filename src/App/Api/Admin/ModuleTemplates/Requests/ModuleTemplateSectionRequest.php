<?php

namespace App\Api\Admin\ModuleTemplates\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateSection;
use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ModuleTemplateSectionRequest extends FormRequest
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
            'section_id' => ['numeric', 'exists:' . LayoutSection::Table() . ',id', 'required', new IsCompositeUnique(
                ModuleTemplateSection::Table(),
                [
                    'template_id' => $this->template_id,
                    'section_id' => $this->section_id,
                ],
                $this->id
            ),],

        ];
    }
}
