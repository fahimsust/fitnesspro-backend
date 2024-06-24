<?php

namespace Support\Contracts\Mail;

interface CanMailTo
{
    public function sendTo(): string;

    public function sendToName(): string;
}
