<?php

namespace Support\Contracts;

abstract class AbstractAction
{
    public static function run(...$args)
    {
        return (new static(...$args))->execute();
    }

    public static function now(...$args)
    {
        $executedAction = static::run(...$args);

        if (!$executedAction instanceof self
            || !method_exists($executedAction, 'result')) {
            return $executedAction;
        }

        return $executedAction->result();
    }

    abstract public function execute();
}
