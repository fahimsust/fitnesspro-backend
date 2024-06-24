<?php

namespace Domain\Photos\Models;

use Domain\Accounts\Models\Account;
use Domain\Events\Models\Event;
use Domain\Trips\Models\TripFlyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class Photo extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'photos';
    protected $appends = ['url'];

    protected $casts = [
        'addedby' => 'int',
        'album' => 'int',
        'approved' => 'bool',
        'added' => 'datetime',
    ];

    protected $fillable = [
        'added',
        'addedby',
        'title',
        'img',
        'album',
        'approved',
    ];

    public function accountProfileImage()
    {
        return $this->hasOne(Account::class, 'photo_id', 'id');
    }

    public function addedBy()
    {
        return $this->belongsTo(Account::class, 'addedby');
    }

    public function album()
    {
        return $this->belongsTo(PhotoAlbum::class, 'album');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'photo');
    }

    public function comments()
    {
        return $this->hasMany(PhotoComment::class);
    }

    public function favoritedBy()
    {
        //todo
        return $this->hasManyThrough(
            Account::class,
            PhotoFavoritedBy::class
        );
    }

    public function getUrlAttribute()
    {
        return "https://assets-fitnessprotravel.sfo3.cdn.digitaloceanspaces.com/catalog/photos/{$this->img}";
    }

    public function tripFlyers()
    {
        return $this->hasMany(TripFlyer::class);
    }
}
