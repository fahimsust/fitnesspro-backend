<?php

namespace App\Api\Admin\CategorySettingsTemplates\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class CategorySettingsTemplateRequest extends FormRequest
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
            'name' => ['string','max:55', 'required'],
            'layout_id' => [
                'int',
                'exists:' . Layout::Table() . ',id',
                Rule::requiredIf(fn () => ($this->layout_id_default == 1)),
                'nullable',
            ],
            'module_template_id' => [
                'int',
                'exists:' . ModuleTemplate::Table() . ',id',
                Rule::requiredIf(fn () => ($this->module_template_id_default == 1)),
                'nullable',
            ],
            'layout_id_default' => [
                'int',
                'nullable',
            ],
            'module_template_id_default' => [
                'int',
                'nullable',
            ],
            'category_thumbnail_template' => [
                'int',
                 Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.category_thumbnail'));
                 }),
                'nullable',
            ],

            'feature_thumbnail_template' => [
                'int',
                 Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.product_thumbnail'));
                 }),
                'nullable',
            ],
            'product_thumbnail_template' => [
                'int',
                 Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.product_thumbnail'));
                 }),
                'nullable',
            ],
            'show_categories_in_body' => [
                'numeric',
                'nullable',
            ],
            'show_featured' => [
                'numeric',
                'nullable',
            ],
            'feature_defaultsort' => [
                'numeric',
                'nullable',
            ],
            'feature_showsort' => [
                'numeric',
                'nullable',
            ],
            'feature_showmessage' => [
                'numeric',
                'nullable',
            ],
            'feature_thumbnail_count' => [
                'int',
                'nullable',
            ],
            'show_products' => [
                'numeric',
                'nullable',
            ],
            'product_thumbnail_showsort' => [
                'numeric',
                'nullable',
            ],
            'product_thumbnail_defaultsort' => [
                'numeric',
                'nullable',
            ],
            'product_thumbnail_count' => [
                'int',
                'nullable',
            ],
            'product_thumbnail_showmessage' => [
                'numeric',
                'nullable',
            ],
            'search_form_id' => [
                'int',
                'exists:' . SearchForm::Table() . ',id',
                'nullable',
            ],
            
        ];
    }
}
