<?php

namespace Support\Traits;

use Illuminate\Support\Collection;
use Support\Contracts\CanReceiveExceptionCollection;

trait HasExceptionCollection
{
    private ?Collection $exceptions = null;

    public function catchToCollection(\Exception $exception)
    {
        $this->exceptions()->push($exception);
    }

    public function transferExceptionsTo(CanReceiveExceptionCollection $object): static
    {
        if (! $this->hasExceptions()) {
            return $this;
        }

        $this->exceptions()
            ->each(
                fn (\Exception $exception) => $object->catchToCollection($exception)
            );

        return $this;
    }

    public function hasExceptions(): bool
    {
        return ! is_null($this->exceptions);
    }

    public function exceptions(): Collection
    {
        return $this->hasExceptions()
            ? $this->exceptions
            : $this->exceptions = collect();
    }

    public function exceptionsToPlainText()
    {
        return $this->exceptions()
            ->map(
                fn (\Exception $exception) => "- {$exception->getMessage()}"
            )
            ->implode("\n");
    }
}
