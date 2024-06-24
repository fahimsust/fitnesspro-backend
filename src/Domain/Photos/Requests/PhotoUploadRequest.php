<?php

namespace Domain\Photos\Requests;

use Domain\Photos\Models\PhotoAlbum;
use Support\Requests\AbstractFormRequest;

class PhotoUploadRequest extends AbstractFormRequest
{
    public ?PhotoAlbum $album = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules = [
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:2048'],
            'title' => ['required', 'string', 'max:255'],
            'album_id' => ['nullable'], //hanlded in loadAlbum - 'exists:photos_albums,id']
        ];

        return $this->rules;
    }

    public function loadAlbum()
    {
        if (is_null($this->album_id)) {
            return;
        }

        return $this->album = PhotoAlbum::findOrFail($this->album_id);
    }

    public function authorize()
    {
        $this->loadAlbum();

        return parent::authorize();
    }
}
