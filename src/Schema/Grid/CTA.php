<?php

namespace Obelaw\Schema\Grid;

use Obelaw\Schema\Common\ActionButton;

class CTA
{
    public $calls = [];

    public function setCall($label, ActionButton $actionButton)
    {
        $this->calls = array_merge($this->calls, [$label => $actionButton->getButton()]);
        return $this;
    }

    public function getCalls()
    {
        return $this->calls;
    }
}
