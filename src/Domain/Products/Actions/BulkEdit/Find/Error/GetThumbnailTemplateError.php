<?php

namespace Domain\Products\Actions\BulkEdit\Find\Error;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetThumbnailTemplateError
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $errors = [];
        if (!$request->template_id) {
            $errors['template_id'] = __('Thumbnail template can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
