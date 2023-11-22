<?php

namespace Obelaw\Drivers\Abstracts;

abstract class Driver
{
    private $prefix = null;

    /**
     * Get the value of prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     *
     * @return  self
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    abstract public function set($key, $values);

    abstract public function get($key);
}
