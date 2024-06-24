<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rule;

class UpdateSectionModuleTemplateRequest extends FormRequest
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
            'module_template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'nullable'],
            'field_name' => ['string','required', Rule::in([
                'search_module_template_id',
                'default_module_template_id',
                'default_category_module_template_id',
                'home_module_template_id',
                'default_product_module_template_id',
                'page_module_template_id',
                'affiliate_module_template_id'
            ]),],
        ];
    }
}
