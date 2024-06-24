<?php

namespace Domain\Messaging\Models\MessageKey;

class MessageKey
{
    private \Illuminate\Support\Collection $keys;

    public function __construct()
    {
        $this->keys = collect([]);
    }

    public function getKeysAttribute(): \Illuminate\Support\Collection
    {
        return $this->keys;
    }

    public function addKeys(array $keys)
    {
        foreach ($keys as $key_id => $key_var) {
            $this->addKey($key_id, $key_var);
        }

        return $this;
    }

    public function addKey($id, $variable)
    {
        $this->keys->add((object) [
            'key_id' => $id,
            'key_var' => $variable,
        ]);

        return $this;
    }

    public function all()
    {
        return $this->keys;
    }
}
