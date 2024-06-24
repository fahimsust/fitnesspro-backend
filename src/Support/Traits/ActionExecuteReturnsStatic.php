<?php

namespace Support\Traits;

trait ActionExecuteReturnsStatic
{

    public static function run(...$args): static
    {
        return parent::run(...$args);
    }

    abstract public function execute(): static;
}
