<?php

namespace Domain\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class TmpFile extends Model
{
    use HasModelUtilities;
    protected $table = 'tmp_files';
}
