<?php

namespace App\Api\Admin\ProductOptions\Requests;

use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CreateProductOptionValueRequest extends FormRequest
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
            'display' => ['string', 'max:100', 'required'],
            'rank' => ['numeric', 'required'],
            'option_id' => ['numeric', 'exists:' . ProductOption::Table() . ',id', 'required'],
            'price' => ['numeric', 'required'],
        ];
    }
}
