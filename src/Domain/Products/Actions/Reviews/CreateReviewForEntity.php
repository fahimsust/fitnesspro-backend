<?php

namespace Domain\Products\Actions\Reviews;

use App\Api\Site\Reviews\Requests\CreateReviewRequest;
use Domain\Products\Contracts\IsReviewable;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateReviewForEntity
{
    use AsObject;

    public function handle(
        IsReviewable $reviewable,
        CreateReviewRequest $request,
    ) {
        return $reviewable->reviews()->create([
            'name' => $request->name,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);
    }
}
