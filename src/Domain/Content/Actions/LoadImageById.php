<?php

namespace Domain\Content\Actions;

use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Support\Contracts\AbstractAction;

class LoadImageById extends AbstractAction
{
    public function __construct(
        public int $imageId
    )
    {
    }

    public function execute(): ?Image
    {
        if (!$this->imageId) {
            return null;
        }

        return Cache::tags([
            'image-cache.' . $this->imageId,
        ])
            ->remember(
                'load-image-by-id.' . $this->imageId,
                60 * 15,
                fn() => $this->load()
            );
    }

    protected function load(): Image
    {
        return Image::find($this->imageId)
            ?? throw new ModelNotFoundException(
                __("No image matching ID {$this->imageId}.")
            );
    }
}
