<?php

namespace App\Api\Admin\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class CategoryMenuSettingsRequest extends FormRequest
{
    use HasFactory;

    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'rank' => ['int', 'required'],
            'show_in_list' => ['bool', 'required'],
            'menu_class' => ['string', 'max:55', 'nullable'],
        ];
    }
}
