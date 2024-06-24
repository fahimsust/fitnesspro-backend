<?php

namespace App\Api\Admin\Referrals\Requests;

use Domain\Affiliates\Models\ReferralStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReferralStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'status_id' => ['numeric', 'exists:' . ReferralStatus::Table() . ',id', 'required'],
        ];
    }
}
