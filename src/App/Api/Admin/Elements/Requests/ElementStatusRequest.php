<?php

namespace App\Api\Admin\Elements\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ElementStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'status' => ['bool', 'required'],
        ];
    }
}
