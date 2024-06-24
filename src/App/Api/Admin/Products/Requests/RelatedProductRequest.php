<?php

namespace App\Api\Admin\Products\Requests;

use App\Rules\IsCompositeUnique;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductRelated;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class RelatedProductRequest extends FormRequest
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
            'related_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
                'required',
                new IsCompositeUnique(
                    ProductRelated::Table(),
                    [
                        'related_id' => $this->related_id,
                        'product_id' => $this->product_id,
                    ],
                    $this->id
                ),
            ],
        ];
    }
}
