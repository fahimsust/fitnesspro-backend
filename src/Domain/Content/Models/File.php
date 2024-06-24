<?php

namespace Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 *
 * @property int $id
 * @property string $caption
 * @property string $filename
 * @property string $filetype
 * @property string $keywords
 *
 * @package Domain\Others\Models
 */
class File extends Model
{
    public $timestamps = false;
    protected $table = 'files';

    protected $fillable = [
        'caption',
        'filename',
        'filetype',
        'keywords',
    ];
}
