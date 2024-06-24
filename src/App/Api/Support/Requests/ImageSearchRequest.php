<?php

namespace App\Api\Support\Requests;

use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class ImageSearchRequest extends FormRequest
{
    use HasFactory;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'product_id' => [
                'int',
                'exists:' . Product::Table() . ',id',
                'nullable',
            ],
        ];
    }
}
