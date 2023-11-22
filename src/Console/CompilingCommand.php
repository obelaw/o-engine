<?php

declare(strict_types=1);

namespace Obelaw\Console;

use Illuminate\Console\Command;
use Obelaw\Facades\Compile;

final class CompilingCommand extends Command
{
    protected $signature = 'obelaw:o:compile';

    protected $description = 'Modules setup';

    public function handle(): void
    {
        Compile::compiling($this->output);

        $this->newLine();
        $this->info('All modules and plugins have been configured.');
    }
}
