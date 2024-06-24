<?php

namespace Domain\Accounts\Models;

use function __;
use Domain\Photos\Models\PhotoAlbum;

//todo is this really a model?  refactor?

class AccountPhotoAlbum
{
    private ?PhotoAlbum $album;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function init($albumId = null)
    {
        if (is_null($albumId)) {
            $this->default();
        } else {
            $this->load($albumId);
        }

        return $this;
    }

    public function get(): ?PhotoAlbum
    {
        return $this->album;
    }

    public static function for(Account $account)
    {
        return PhotoAlbum::forAccount($account);
    }

    public function load($albumId)
    {
        return $this->album = PhotoAlbum::whereId($albumId)->where('type', '!=', 2)->whereTypeId($this->account->id)->firstOrFail();
    }

    public function create($name, $description = '')
    {
        return PhotoAlbum::factory()->create([
            'description' => $description,
            'name' => $name,
            'type' => 1,
            'type_id' => $this->account->id,
        ]);
    }

    public function default()
    {
        $album = $this->account->album;
        if (is_null($album) || $album->count() === 0) {
            $album = $this->create(__('My Photos'));

            $this->account->load('album');
        }

        $this->album = $album;

        return $this->album;
    }
}
