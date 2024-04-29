<?php

namespace Obelaw\Compiles\Scan\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Scan\Modules\FormsCompile;
use Obelaw\Facades\Bundles;
use Obelaw\Schema\Form\Action;
use Obelaw\Schema\Form\Fields;

class FormsPluginCompile extends FormsCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outForms = Bundles::getForms();

        $consoleOutput?->writeln('Forms for plugin Compile...');

        foreach ($paths as $id => $path) {
            $_form = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/forms')) {

                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                    $formClass = include($filename);

                    $fields = new Fields;
                    $actions = new Action;

                    if (method_exists($formClass, 'actions')) {
                        $formClass->actions($actions);
                    }

                    (new $formClass)->form($fields);

                    $formId = $id . '_' . basename($filename, '.php');

                    if (isset($this->appendFields($paths)[$formId])) {
                        $fields->mergeFields($this->appendFields($paths)[$formId]);
                    }

                    $_form[$id . '_' . basename($filename, '.php')] = [
                        'fields' => $fields->getFields(),
                        'actions' => $actions->getActions(),
                    ];
                }

                $outForms = array_merge($outForms, $_form);
            }
        }

        $consoleOutput?->writeln('Forms for plugin Compiled.');
        $consoleOutput?->newLine();

        return $outForms;
    }

    /**
     * Append external fields
     * 
     * Example:-
        use Obelaw\Framework\Builder\Form\Fields;

        return new class
        {
            public $appendTo = '<form_id>';

            public function form(Fields $form)
            {
                ...
            }
        };
     */
    public function appendFields($paths)
    {
        $outfields = [];

        foreach ($paths as $id => $path) {
            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . 'appends')) {
                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/forms' . DIRECTORY_SEPARATOR . 'appends' . DIRECTORY_SEPARATOR . '*.php') as $filename) {
                    $formClass = include($filename);

                    $fields = new Fields;

                    $formClass = new $formClass;

                    $formClass->form($fields);

                    $outfields[$formClass->appendTo] = array_merge($outfields[$formClass->appendTo] ?? [], $fields->getFields());
                }
            }
        }

        return $outfields;
    }
}
