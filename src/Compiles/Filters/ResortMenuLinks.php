<?php

namespace Obelaw\Compiles\Filters;

class ResortMenuLinks
{
    public function apply($values)
    {
        return collect($values)->map(function ($navbar) {
            return collect($navbar)->map(function ($_navbar) {
                if (isset($_navbar['sublinks'])) {
                    $_navbar['sublinks'] = collect($_navbar['sublinks'])->map(function ($__navbar) {

                        if (isset($__navbar['thirdlinks'])) {
                            $__navbar['thirdlinks'] = collect($__navbar['thirdlinks'])->map(function ($___navbar) {
                                return $___navbar;
                            })->sortBy('position')->toArray();
                        }

                        return $__navbar;
                    })->sortBy('position')->toArray();
                }

                return $_navbar;
            })->sortBy('position')->toArray();
        })->sortBy('position')->toArray();
    }
}
