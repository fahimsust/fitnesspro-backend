<?php

namespace Domain\Photos\Collections;

use Illuminate\Support\Collection;

//todo replace with photo size models for settings
//and with image hosting service's dynamic sizing
class PhotoSizesCollection extends Collection
{
    private static $magicStaticMethods = [
        'orderByAsc',
        'orderByDesc',
    ];

    public function __construct()
    {
        parent::__construct(
            config('photos.sizes')
        );
    }

    public function orderByAsc(string $field): static
    {
        return $this->sortBy($field);
    }

    public function orderByDesc(string $field): static
    {
        return $this->sortByDesc($field);
    }
}
