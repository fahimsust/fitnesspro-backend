<?php

namespace App\Api\Admin\Faqs\Requests;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Worksome\RequestFactories\Concerns\HasFactory;

class FaqRequest extends FormRequest
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
    public function urlRule()
    {
        $validation = ['string','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:85', 'required'];
        if (isset($this->faq->id)) {
            $validation[] = 'unique:'.Faq::Table().',url,'.$this->faq->id;
        } else {
            $validation[] = 'unique:'.Faq::Table();
        }
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'question' => ['string','max:255', 'required'],
            'url' => $this->urlRule(),
            'categories_id' => [
                'array',
                'required',
            ],
            'categories_id.*' => [
                'int',
                Rule::exists(FaqCategory::Table(), 'id'),
            ],
            'answer' => ['string','required'],
            'status' => ['boolean','required'],
            'rank' => ['int', 'required'],
        ];
    }
}
