<?php

namespace App\Api\Admin\Pages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Worksome\RequestFactories\Concerns\HasFactory;

class PageRequest extends FormRequest
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
        $validation = ['string','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:155', 'required'];
        if (isset($this->page->id)) {
            $validation[] = 'unique:pages,url_name,'.$this->page->id;
        } else {
            $validation[] = 'unique:pages';
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
            'title' => ['string','max:255', 'required'],
            'url_name' => $this->urlRule(),
            'page_content' => ['string', 'nullable'],
            'notes' => ['string', 'max:100', 'nullable'],
        ];
    }
}
