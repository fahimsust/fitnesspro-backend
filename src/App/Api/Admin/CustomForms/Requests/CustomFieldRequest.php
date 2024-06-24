<?php

namespace App\Api\Admin\CustomForms\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;
use Illuminate\Validation\Rule;

class CustomFieldRequest extends FormRequest
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
            'name' => ['string','max:255', 'required'],
            'display' => ['string','max:255', 'required'],
            'required' => ['bool', 'required'],
            'status' => ['bool', 'required'],
            'type' => ['int', 'required',Rule::in([0,1,2,3,4,5,6])],
            'specs' => ['int', 'nullable',Rule::in([1,2,3])]
        ];
    }
}
