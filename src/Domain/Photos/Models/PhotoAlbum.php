<?php

namespace Domain\Photos\Models;

use function __;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\HasModelUtilities;

class PhotoAlbum extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'photos_albums';

    //todo: refactor to action
    public function newPhoto(Photo $photo)
    {
        $this->update([
            'recent_photo_id' => $photo->id,
            'photos_count' => $this->photos_count++,
        ]);
    }

    public function belongsToAccount(Account $account)
    {
        if ($this->type === 1 && $this->type_id === $account->id) {
            return true;
        }

        throw new \Exception(__('Album does not match account'), 403);
    }

    public function scopeForAccount($query, Account $account)
    {
        return $query->where('type_id', '=', $account->id)
            ->where('type', 1)
            ->orderBy('updated', 'desc');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'type_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(
            Photo::class,
            'album',
            'id'
        );
    }
}
