<?php

namespace App\Api\Admin\MessageTemplates\Requests;

use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class MessageTemplateRequest extends FormRequest
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
    public function messageCategoryRule()
    {
        $validation = ['nullable'];
        if ($this->input('category_id') && !is_array($this->input('category_id'))) {
            $validation[] = Rule::when(
                $this->input('category_id') && is_int($this->input('category_id')),
                [
                    'integer',
                    Rule::exists(MessageTemplateCategory::Table(), 'id'),
                ],
                [
                    'string',
                    'max:255',
                    Rule::unique(MessageTemplateCategory::Table(), 'name')
                ]
            );
        }
        return $validation;
    }
    public function rules()
    {
        return array_merge(
            [
                'name' => ['string', 'max:55', 'required'],
                'subject' => ['string', 'max:255', 'required'],
                'alt_body' => ['string', 'required'],
                'html_body' => ['string', 'required'],
                'note' => ['string', 'max:255', 'nullable'],
                'system_id' => ['string', 'max:85', 'nullable'],
                'category_id' => ['numeric', 'exists:' . MessageTemplateCategory::Table() . ',id', 'nullable'],
            ]
        );
    }
}
