<?php

namespace Support\Traits;

trait CanUseCache
{
    public bool $useCache = true;

    public function useCache(bool $use): static
    {
        $this->useCache = $use;

        return $this;
    }
}
