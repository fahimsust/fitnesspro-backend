<?php

namespace App\Api\Admin\ModuleTemplates\Requests;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Category\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class ModuleTemplateRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'required'],
            'parent_template_id' => ['numeric', 'exists:' . ModuleTemplate::Table() . ',id', 'nullable'],
        ];
    }
}
