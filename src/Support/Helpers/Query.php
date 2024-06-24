<?php

namespace Support\Helpers;

class Query
{
    public static function toSql($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            $binding = addslashes($binding);

            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}
