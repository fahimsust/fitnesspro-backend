<?php

namespace App\Api\Admin\DisplayTemplates\Requests;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class DisplayTemplateRequest extends FormRequest
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
            'name' => ['string', 'max:55', 'required'],
            'include' => ['string', 'max:255', 'required'],
            'image_width' => ['string', 'max:10', 'nullable'],
            'image_height' => ['string', 'max:10', 'nullable'],
            'type_id' => ['numeric', 'exists:' . DisplayTemplateType::Table() . ',id', 'required'],
        ];
    }
}
