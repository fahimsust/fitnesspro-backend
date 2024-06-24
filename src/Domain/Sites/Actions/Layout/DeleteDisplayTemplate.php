<?php

namespace Domain\Sites\Actions\Layout;

use Domain\Sites\Models\Layout\DisplayTemplate;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteDisplayTemplate
{
    use AsObject;

    public function handle(
        DisplayTemplate $displayTemplate
    ): bool {
        $displayTemplate->delete();

        return true;
    }
}
