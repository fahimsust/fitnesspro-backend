<?php

namespace Domain\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Contracts\Mail\CanMailTo;
use Support\Traits\HasModelUtilities;

class SupportDepartment extends Model implements CanMailTo
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'support_departments';
    public function sendTo(): string
    {
        return $this->email;
    }
    public function sendToName(): string
    {
        return $this->name;
    }
}
