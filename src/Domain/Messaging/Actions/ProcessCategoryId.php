<?php

namespace Domain\Messaging\Actions;

use Domain\Messaging\Models\MessageTemplateCategory;
use Support\Contracts\AbstractAction;

class ProcessCategoryId extends AbstractAction
{
    public function __construct(
        public $data,
    ) {
    }

    public function execute(): array
    {

        if (isset($this->data['category_id']) && is_array($this->data['category_id']) && empty($this->data['category_id'])) {
            $this->data['category_id'] = null;
        }
        if (isset($this->data['category_id']) && is_string($this->data['category_id'])) {

            $newCategory = MessageTemplateCategory::create(['name' => $this->data['category_id'], 'parent_id' => null]);
            $this->data['category_id'] = $newCategory->id;
        }
        return $this->data;
    }
}
