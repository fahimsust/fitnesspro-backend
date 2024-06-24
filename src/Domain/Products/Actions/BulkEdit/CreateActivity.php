<?php
namespace Domain\Products\Actions\BulkEdit;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\BulkEdit\BulkEditActivity;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateActivity
{
    use AsObject;

    public function handle(
        array $ids,
        array $changeTo,
        ActionList $enumField

    ):int {
        BulkEditActivity::create([
            'action_type'=> $enumField,
            'action_changeto'=>json_encode($changeTo),
            'products_edited'=>count($ids)
        ]);
        return count($ids);
    }
}
