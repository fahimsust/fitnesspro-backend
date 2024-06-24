<?php

namespace Support\Contracts;

interface HasSubjectMessage
{
    public function message(): string;

    public function subject(): string;
}
