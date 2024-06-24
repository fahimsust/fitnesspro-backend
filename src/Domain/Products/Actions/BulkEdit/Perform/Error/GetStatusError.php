<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetStatusError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->status && $request->status !== '0' && $request->status !== 0) {
            $errors['status'] = __('Status can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
