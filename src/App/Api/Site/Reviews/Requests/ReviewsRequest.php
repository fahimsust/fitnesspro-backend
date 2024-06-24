<?php

namespace App\Api\Site\Reviews\Requests;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Worksome\RequestFactories\Concerns\HasFactory;

class ReviewsRequest extends FormRequest
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
            'product_id' => ['numeric', 'exists:' . Product::Table() . ',id', 'required_without:option_id'],
            'option_id' => ['numeric', 'exists:' . AttributeOption::Table() . ',id', 'required_without:product_id'],
        ];
    }
}
