<?php

namespace Domain\Photos\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PhotosSize
 *
 * @property int $id
 * @property int $width
 * @property int $height
 * @property string $crop
 *
 * @package Domain\Photos\Models
 */
class PhotoSize extends Model
{
    public $timestamps = false;
    protected $table = 'photos_sizes';

    protected $casts = [
        'width' => 'int',
        'height' => 'int',
    ];

    protected $fillable = [
        'width',
        'height',
        'crop',
    ];
}
