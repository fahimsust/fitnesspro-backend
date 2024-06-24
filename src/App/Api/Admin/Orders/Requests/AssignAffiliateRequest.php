<?php

namespace App\Api\Admin\Orders\Requests;

use Domain\Affiliates\Models\Affiliate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class AssignAffiliateRequest extends FormRequest
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
            'affiliate_id' => ['int', 'exists:' . Affiliate::Table() . ',id', 'required'],
        ];
    }
}
