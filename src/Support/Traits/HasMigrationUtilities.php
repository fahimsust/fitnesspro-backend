<?php

namespace Support\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait HasMigrationUtilities
{
    protected array $foreignKeys = [];

    protected function isLocalOrTesting()
    {
        return app()->environment(['local', 'testing']);
    }

    protected function defaultTimestamps(
        Blueprint $table,
        string $namingConvention = '_at'
    )
    {
        $this->defaultCreated($table, $namingConvention);
        $this->defaultUpdated($table, $namingConvention);
    }

    protected function defaultCreated($table, $namingConvention = '_at')
    {
        $table->timestamp('created'.$namingConvention, 0)->useCurrent();                      //->default(DB::raw('CURRENT_TIMESTAMP'));
    }

    protected function defaultUpdated($table, $namingConvention = '_at')
    {
        $table->timestamp('updated'.$namingConvention, 0)->useCurrent()->useCurrentOnUpdate();//default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    }

    protected function disableForeignKeys()
    {
        Schema::disableForeignKeyConstraints();
    }

    protected function enableForeignKeys()
    {
        Schema::enableForeignKeyConstraints();
    }

    protected function listTableForeignKeys($table)
    {
        if (isset($this->foreignKeys[$table])) {
            return $this->foreignKeys[$table];
        }

        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return $this->foreignKeys[$table] = array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    protected function hasForeignKey($tableName, $key)
    {
        return in_array($key, $this->listTableForeignKeys($tableName));
    }

    protected function dropForeignIfExists(Blueprint $table, $key)
    {
        if ($this->hasForeignKey($table->getTable(), $key)) {
            $table->dropForeign($key);
        }
    }
}
