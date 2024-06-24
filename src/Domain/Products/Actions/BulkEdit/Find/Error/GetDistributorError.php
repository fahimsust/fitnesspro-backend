<?php

namespace Domain\Products\Actions\BulkEdit\Find\Error;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetDistributorError
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $errors = [];
        if (!$request->distributor_id) {
            $errors['distributor_id'] = __('Distributor Id can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
