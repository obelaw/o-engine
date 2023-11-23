<?php

namespace Obelaw\Schema\Common;

abstract class ActionButton
{
    public $button = null;

    public function getButton()
    {
        return $this->button;
    }
}
