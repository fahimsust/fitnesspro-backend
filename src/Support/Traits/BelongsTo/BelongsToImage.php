<?php

namespace Support\Traits\BelongsTo;

use Domain\Content\Actions\LoadImageById;
use Domain\Content\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToImage
{
    private ?Image $imageCached = null;

    public function image(): BelongsTo
    {
        return $this->belongsTo(
            Image::class,
            'image_id'
        );
    }

    public function imageCached(): ?Image
    {
        if ($this->relationLoaded('image')) {
            return $this->image;
        }

        $this->imageCached ??= LoadImageById::now($this->image_id);

        $this->setRelation('image', $this->imageCached);

        return $this->imageCached;
    }
}
