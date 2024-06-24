<?php

namespace App\Api\Admin\Products\Requests;

use App\Rules\IsCompositeUnique;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ProductFormRequest extends FormRequest
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
            'form_id' => [
                'int',
                'exists:' . CustomForm::Table() . ',id',
                'required',
            ],
            'rank' => ['int', 'nullable'],
        ];
    }
}
