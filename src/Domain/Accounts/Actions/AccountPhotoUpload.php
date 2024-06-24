<?php

namespace Domain\Accounts\Actions;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountPhotoAlbum;
use Domain\Content\Actions\ResizeSaveImage;
use Domain\Photos\Actions\SetPhotoToUploaded;
use Domain\Photos\Collections\PhotoSizesCollection;
use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;

class AccountPhotoUpload
{
    private Account $account;

    private $fileStream;

    private PhotoAlbum $album;

    private array $saved;

    private Photo $new_photo;

    public function __construct(Account $account, $fileStream, $album = null)
    {
        $this->account = $account;
        $this->fileStream = $fileStream;

        if (is_a($album, PhotoAlbum::class) && $album->belongsToAccount($this->account)) {
            $this->album = $album;
        } else {
            $this->album = (new AccountPhotoAlbum($account))->init($album)->get();
        }
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * @param  Photo  $photo
     */
    public function resizeAndSave(Photo $photo)
    {
        $photoSizes = (new PhotoSizesCollection())
            ->orderByDesc('width')
            ->orderByDesc('height')
            ->all();
//        $photoSizes = PhotoSize::orderByDesc('width')->orderByDesc('height')->get();

        //upload photo
        $resizer = (new ResizeSaveImage($this->fileStream, 0, 0))
            ->thumbs($photoSizes)
            ->resize();

        //save and update photo record
        (new SetPhotoToUploaded())(
            $photo,
            $resizer->save($photo->id.'_', 'catalog/photos/')
        );

        $this->album->newPhoto($photo);

        $this->saved = $resizer->saved;
        $this->new_photo = $photo;

        return $this;
    }

    public function albumId()
    {
        return $this->album->id;
    }

    public function createPhoto($title)
    {
        return Photo::factory()->create([
            'addedby' => $this->account->id,
            'title' => $title,
            'album' => $this->album->id,
            'approved' => false,
        ]);
    }

    public function upload($title)
    {
        //create photo record
        $photo = $this->createPhoto($title);

        try {
            return $this->resizeAndSave($photo);
        } catch (\Throwable $exception) {
            $photo->forceDelete();

            throw $exception;
        }
    }

    public function uploadedData()
    {
        $newPhoto = $this->new_photo;

        return [
            'saved' => $this->saved,
            'album_id' => $this->album->id,
            'photo_id' => $newPhoto->id,
            'photo_url' => $newPhoto->url,
            'photo_filename' => $newPhoto->img,
        ];
    }
}
