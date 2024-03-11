<?php

namespace Obelaw\Schema\Seed;

class Seed
{
    private $seeds = [];

    public function seedClass($seedClass)
    {
        array_push($this->seeds, $seedClass);

        return $this;
    }

    public function getSeeds()
    {
        return $this->seeds;
    }
}
