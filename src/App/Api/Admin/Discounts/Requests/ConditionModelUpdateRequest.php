<?php

namespace App\Api\Admin\Discounts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConditionModelUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'required_qty' => [
                'int',
                'required'
            ],
        ];
    }
}
