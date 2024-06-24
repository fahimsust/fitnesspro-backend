<?php

namespace Domain\Messaging\Models\MessageKey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

abstract class MessageKeyBase extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $guarded = [];
}
