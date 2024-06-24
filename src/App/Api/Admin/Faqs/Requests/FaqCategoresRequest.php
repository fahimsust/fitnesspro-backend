<?php

namespace App\Api\Admin\Faqs\Requests;

use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FaqCategoresRequest extends FormRequest
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
            'categories_id' => ['numeric', 'exists:' . FaqCategory::Table() . ',id', 'required'],
        ];
    }
}
