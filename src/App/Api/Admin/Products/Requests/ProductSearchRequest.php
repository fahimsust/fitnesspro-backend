<?php

namespace App\Api\Admin\Products\Requests;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductSearchRequest extends FormRequest
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
            'keyword' => ['string', 'nullable'],
            'type_id' => ['int', 'exists:' . ProductType::Table() . ',id','nullable'],
            'brand_id' => ['int', 'exists:' . Brand::Table() . ',id','nullable'],
            'product_id' => ['int', 'exists:' . Product::Table() . ',id','nullable'],
            'hide_children' => ['bool', 'nullable'],
            'trashed' => ['bool', 'nullable'],
        ];
    }
}
