<?php

namespace App\Api\Admin\Products\Types\Requests;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductTypeAttributeSetRequest extends FormRequest
{
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
            'set_ids' => [
                'array',
                'nullable'
            ],
            'set_ids.*' => [
                'int',
                'exists:' . AttributeSet::Table() . ',id',
                'nullable'
            ],
        ];
    }
}
