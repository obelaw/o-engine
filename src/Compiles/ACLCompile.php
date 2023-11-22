<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\ACL\Section;

class ACLCompile extends Compile
{
    public $driverKey = 'obelawACLs';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outACL = [];
        $bar = null;

        $consoleOutput?->info('ACLs Compile...');

        if ($consoleOutput) {
            $bar = $consoleOutput->createProgressBar(count($paths));
            $bar->start();
        }

        foreach ($paths as $id => $path) {
            $pathACLFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'ACL.php';

            if (file_exists($pathACLFile)) {

                $ACLClass = include($pathACLFile);
                $ACLClass = new $ACLClass;

                $section = new Section;

                $ACLClass->permissions($section);

                $outACL = array_merge($outACL, [$id => $section->getSection()]);
            }

            $bar?->advance();
        }

        $bar?->finish();

        $consoleOutput?->info('ACLs Compiled.');

        return $outACL;
    }
}
