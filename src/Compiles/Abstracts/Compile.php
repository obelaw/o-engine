<?php

namespace Obelaw\Compiles\Abstracts;

use Illuminate\Console\OutputStyle;

abstract class Compile
{
    abstract public function scanner($paths, OutputStyle $consoleOutput = null);

    abstract public function setToDriver($values);

    abstract public function manage($paths, OutputStyle $consoleOutput = null);
}
