<?php

namespace App\Api\Accounts\Requests;

use Domain\Photos\Requests\PhotoUploadRequest;

class AccountPhotoUploadRequest extends PhotoUploadRequest
{
    public function authorize()
    {
        if (! parent::authorize()) {
            return false;
        }

        if ($this->album && ! $this->album->belongsToAccount($this->account)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return parent::rules();
    }
}
