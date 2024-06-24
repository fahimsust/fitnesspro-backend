<?php

namespace Domain\Support\Contracts;

interface ActionWithLogMsg
{
    public function logMsg(): string;

    public function execute(): static;
}
