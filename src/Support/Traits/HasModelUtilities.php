<?php

namespace Support\Traits;

trait HasModelUtilities
{
    public function usesTimestamps()
    {
        return false;
    }

    public function getTable()
    {
        return $this->table ?? parent::getTable();
    }

    public static function Table()
    {
        return with(new static())->getTable();
    }

    public static function firstOrFactory($attributes = [])
    {
        if ($object = static::firstWhere($attributes)) {
            return $object;
        }

        return static::factory($attributes)->create();
    }

    public function loadMissingReturn(string $relation)
    {
        return $this->loadMissing($relation)->$relation;
    }
}
