<?php

namespace Domain\Products\Actions\BulkEdit\Perform\Error;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Validation\ValidationException;

class GetDistributorError
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ) {
        $errors = [];
        if (!$request->distributor_id) {
            $errors['distributor_id'] = __('Distributor can\'t be empty');
        }
        if(count($errors) > 0)
        {
            throw ValidationException::withMessages($errors);
        }
    }
}
