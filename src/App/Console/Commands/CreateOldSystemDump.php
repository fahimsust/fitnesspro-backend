<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class CreateOldSystemDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-old-system-dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create old system dump';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (App::isProduction()) {
            throw new \Exception('This command cannot be run in production.');
        }

        if (file_exists('database/schema/mysql-schema.sql')) {
            rename('database/schema/mysql-schema.sql', 'database/schema/mysql-schema.back.sql');
        }

        $this->call('migrate:fresh', [
            '--seed',
            '--path' => 'database/migrations/0_old_migrations',
        ]);

        $this->call('schema:dump');

        rename('database/schema/mysql-schema.sql', 'database/schema/mysql-schema.old-system.sql');

        if (file_exists('database/schema/mysql-schema.back.sql')) {
            rename('database/schema/mysql-schema.back.sql', 'database/schema/mysql-schema.sql');
        }
    }
}
