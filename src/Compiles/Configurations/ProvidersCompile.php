<?php

namespace Obelaw\Compiles\Configurations;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Framework\Base\ServiceProviderBase;

class ProvidersCompile extends Compile
{
    public $driverKey = 'obelawProviders';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outProviders = [];

        $consoleOutput?->writeln('Providers Compile...');

        foreach ($paths as $path) {
            foreach ($path as $_provider) {
                if (!in_array($_provider, $outProviders)) {
                    throw_if(!is_subclass_of($_provider, ServiceProviderBase::class), 'This ' . $_provider . ' is not extends from ' . ServiceProviderBase::class);
                    array_push($outProviders, $_provider);
                }
            }
        }

        $consoleOutput?->writeln('Providers Compiled.');
        $consoleOutput?->newLine();

        return $outProviders;
    }
}
