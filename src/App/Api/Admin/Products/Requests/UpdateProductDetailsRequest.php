<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class UpdateProductDetailsRequest extends FormRequest
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
            'brand_id' => [
                'int',
                'exists:' . Brand::Table() . ',id',
                'nullable',
            ],
            'downloadable' => ['bool', 'nullable'],
            'downloadable_file' => ['string','max:200','nullable'],
            'default_category_id' => [
                'int',
                'exists:' . Category::Table() . ',id',
                'nullable',
            ],
            'create_children_auto' => ['bool', 'nullable'],
            'display_children_grid' => ['bool', 'nullable'],
            'override_parent_description' => ['bool', 'nullable'],
            'allow_pricing_discount' => ['bool', 'nullable'],
        ];
    }
}
