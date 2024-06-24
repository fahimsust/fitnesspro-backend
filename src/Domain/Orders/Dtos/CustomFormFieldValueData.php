<?php

namespace Domain\Orders\Dtos;

use Spatie\LaravelData\Data;

class CustomFormFieldValueData extends Data
{
    public function __construct(
        public int $formId,
        public int $sectionId,
        public int $fieldId,
        public string|array $value
    ) {
    }

    public function toArray(): array
    {
        return [
            'form_id' => $this->formId,
            'section_id' => $this->sectionId,
            'field_id' => $this->fieldId,
            'value' => $this->value,
        ];
    }
}
