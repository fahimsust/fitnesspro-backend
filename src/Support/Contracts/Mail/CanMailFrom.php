<?php

namespace Support\Contracts\Mail;

interface CanMailFrom
{
    public function sendFrom(): string;

    public function sendFromName(): string;
}
