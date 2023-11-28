<?php

namespace App\Services;

use App\Models\Race;

class RaceService
{
    protected $race;
    public function __construct(Race $race)
    {
        $this->race = $race;
    }

    /**
     * 
     */
    public function index()
    {
        return $this->race->all();
    }
}
