<?php

namespace App\Api\Admin\Faqs\Requests;

use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class FaqCategoryRequest extends FormRequest
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
        if (isset($this->faq_category->id)) {
            $validation[] = 'unique:'.FaqCategory::Table().',url,'.$this->faq_category->id;
        } else {
            $validation[] = 'unique:'.FaqCategory::Table();
        }
        return $validation;
    }

    public function titleRule()
    {
        $validation = ['string','max:85', 'required'];
        if (isset($this->faq_category->id)) {
            $validation[] = 'unique:'.FaqCategory::Table().',title,'.$this->faq_category->id;
        } else {
            $validation[] = 'unique:'.FaqCategory::Table();
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
            'title' => $this->titleRule(),
            'url' => $this->urlRule(),
            'status' => ['boolean','required'],
            'rank' => ['int', 'required'],
        ];
    }
}
