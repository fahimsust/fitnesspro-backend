<?php

namespace App\Api\Admin\Discounts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdvantageModelUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'applyto_qty' => [
                'int',
                'required'
            ],
        ];
    }
}
