<?php

namespace Obelaw\Compiles\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\ACLCompile;
use Obelaw\Facades\Bundles;
use Obelaw\Schema\ACL\Section;

class ACLPluginCompile extends ACLCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outACL = Bundles::getACLs();

        $consoleOutput?->writeln('ACLs for plugin Compile...');


        foreach ($paths as $id => $path) {
            $pathACLFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'ACL.php';

            if (file_exists($pathACLFile)) {

                $ACLClass = include($pathACLFile);
                $ACLClass = new $ACLClass;

                $section = new Section;

                $ACLClass->permissions($section);

                $outACL = array_merge($outACL, [$id => $section->getSection()]);
            }
        }

        $consoleOutput?->writeln('ACLs for plugin Compiled.');
        $consoleOutput?->newLine();

        return $outACL;
    }
}
