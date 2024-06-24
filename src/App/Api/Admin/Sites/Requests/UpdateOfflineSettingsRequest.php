<?php

namespace App\Api\Admin\Sites\Requests;

use Domain\Sites\Models\Layout\Layout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateOfflineSettingsRequest extends FormRequest
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
            'offline_message' => ['string', 'required'],
            'offline_layout_id' => ['numeric', 'exists:' . Layout::Table() . ',id', 'required'],
        ];
    }
}
