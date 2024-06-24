<?php

namespace App\Api\Admin\ProductSettingsTemplates\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductSettingsTemplateRequest extends FormRequest
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
            'product_detail_template' => [
                'int',
                Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.product_detail'));
                }),
                Rule::requiredIf(fn () => ($this->product_detail_template_default == 1)),
                'nullable',
            ],
            'product_thumbnail_template' => [
                'int',
                 Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.product_thumbnail'));
                 }),
                 Rule::requiredIf(fn () => ($this->product_thumbnail_template_default == 1)),
                'nullable',
            ],
            'product_zoom_template' => [
                'int',
                 Rule::exists(DisplayTemplate::Table(),'id')->where(function($query) {
                    $query->where('type_id',config('display_templates.product_zoom'));
                 }),
                 Rule::requiredIf(fn () => ($this->product_zoom_template_default == 1)),
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
            'product_detail_template_default' => [
                'int',
                'nullable',
            ],
            'product_thumbnail_template_default' => [
                'int',
                'nullable',
            ],
            'product_zoom_template_default' => [
                'int',
                'nullable',
            ],
            
        ];
    }
}
