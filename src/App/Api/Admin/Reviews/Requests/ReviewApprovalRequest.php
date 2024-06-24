<?php

namespace App\Api\Admin\Reviews\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewApprovalRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'approved' => ['bool', 'required'],
        ];
    }
}
