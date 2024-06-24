<?php

namespace Domain\Products\Actions\BulkEdit\Find\Error;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetParentError
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $errors = [];
        if (!$request->value) {
            $errors['value'] = __('Parent Id can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
