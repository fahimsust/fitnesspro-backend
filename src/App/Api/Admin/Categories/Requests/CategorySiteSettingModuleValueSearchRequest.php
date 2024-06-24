<?php

namespace App\Api\Admin\Categories\Requests;

use Domain\Modules\Models\Module;
use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CategorySiteSettingModuleValueSearchRequest extends FormRequest
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
            'category_id' => [
                'int',
                'exists:' . Category::Table() . ',id',
                'required',
            ],
            'module_id' => [
                'int',
                'exists:' . Module::Table() . ',id',
                'required',
            ],
            'section_id' => [
                'int',
                'exists:' . LayoutSection::Table() . ',id',
                'required',
            ],

        ];
    }
}
