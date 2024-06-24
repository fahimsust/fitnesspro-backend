<?php

namespace Support\Contracts;

interface CanReceiveExceptionCollection
{
    public function catchToCollection(\Exception $exception);
}
