<?php

namespace Obelaw\Schema\Scaneer;

class Scaneer
{
    const BOOT = 1;
    const BOOTING = 2;
    const BOOTED = 3;

    public $scaneers = [];

    public function add($scaneer, $position = 2)
    {
        $scaneer = [
            'position' => $position,
            'scaneer' => $scaneer,
        ];

        array_push($this->scaneers, $scaneer);
    }

    public function scaneers()
    {
        return $this->scaneers;
    }
}
