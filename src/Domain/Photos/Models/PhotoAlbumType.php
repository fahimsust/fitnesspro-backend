<?php

namespace Domain\Photos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class PhotoAlbumType extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'photos_albums_type';

    protected $fillable = [
        'name',
    ];
}
