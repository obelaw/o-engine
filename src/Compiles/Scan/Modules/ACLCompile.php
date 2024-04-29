<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\ACL\Section;

class ACLCompile extends Compile
{
    public $driverKey = 'obelawACLs';

    public function scanner($modules, OutputStyle $consoleOutput = null)
    {
        $outACL = [];

        $consoleOutput?->writeln('ACLs Compile...');

        foreach ($modules as $id => $path) {
            $pathACLFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'ACL.php';

            if (file_exists($pathACLFile)) {

                $ACLClass = include($pathACLFile);
                $ACLClass = new $ACLClass;

                $section = new Section;

                $ACLClass->permissions($section);

                $outACL = array_merge($outACL, [$id => $section->getSection()]);
            }
        }

        $consoleOutput?->writeln('ACLs Compiled.');
        $consoleOutput?->newLine();

        return $outACL;
    }
}
