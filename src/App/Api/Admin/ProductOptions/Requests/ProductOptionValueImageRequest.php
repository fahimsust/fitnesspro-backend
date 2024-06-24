<?php

namespace App\Api\Admin\ProductOptions\Requests;

use Domain\Content\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductOptionValueImageRequest extends FormRequest
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
            'image_id' => ['numeric', 'exists:' . Image::Table() . ',id', 'nullable'],
        ];
    }
}
