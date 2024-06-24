<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductSiteSettingModuleValueRequest extends FormRequest
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
            'site_id' => [
                'int',
                'exists:' . Site::Table() . ',id',
                'nullable',
            ],
            'product_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
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
