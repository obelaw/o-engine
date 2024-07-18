<?php

declare(strict_types=1);

namespace Obelaw\Console;

use Illuminate\Console\Command;
use Obelaw\Compiles\CompileManagement;
use Obelaw\Compiles\Scan\AddonsPaths;
use Obelaw\Drivers\CacheDriver;

final class CompilingCommand extends Command
{
    protected $signature = 'obelaw:o:compile';

    protected $description = 'Modules setup';

    public function handle(): void
    {
        $driver = config('obelaw.engine.driver', CacheDriver::class);
        $driver = new $driver;

        $addonsPaths = new AddonsPaths;
        $compileManagement = new CompileManagement($driver, $addonsPaths);
        $compileManagement->compiling($this->output);

        $this->newLine();
        $this->info('All modules and plugins have been configured.');
    }
}
