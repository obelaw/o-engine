<?php

namespace Obelaw\Console;

use Illuminate\Console\MigrationGeneratorCommand;
// use Symfony\Component\Console\Attribute\AsCommand;

// #[AsCommand(name: 'session:table')]
class DriverTableCommand extends MigrationGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'obelaw:o:driver:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the driver database table';

    /**
     * Get the migration table name.
     *
     * @return string
     */
    protected function migrationTableName()
    {
        return config('obelaw.database.table_prefix', 'obelaw_') . 'o_compiles';
    }

    /**
     * Get the path to the migration stub file.
     *
     * @return string
     */
    protected function migrationStubFile()
    {
        return __DIR__ . '/stubs/database.stub';
    }
}
