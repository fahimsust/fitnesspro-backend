<?php

namespace App\Api\Admin\Categories\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategorySiteSettingsRequest extends FormRequest
{
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
            'site_id' => [
                'int',
                'exists:' . Site::Table() . ',id',
                'nullable',
                new IsCompositeUnique(
                    CategorySiteSettings::Table(),
                    [
                        'site_id' => $this->site_id,
                        'category_id' => $this->category_id,
                    ],
                    $this->id
                ),
            ],
            'settings_template_id' => [
                'int',
                'exists:' . CategorySettingsTemplate::Table() . ',id',
                Rule::requiredIf(fn () => ($this->settings_template_id_default == 1)),
                'nullable',
            ],
            'settings_template_id_default' => [
                'int',
                'nullable',
            ],
            'module_template_id' => [
                'int',
                'exists:' . ModuleTemplate::Table() . ',id',
                Rule::requiredIf(fn () => ($this->module_template_id_default == 1)),
                'nullable',
            ],
            'module_template_id_default' => [
                'int',
                'nullable',
            ],
        ];
    }
}
