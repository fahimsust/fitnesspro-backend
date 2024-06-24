<?php

namespace Domain\Products\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface IsReviewable
{
    public function reviews(): MorphMany;
}
