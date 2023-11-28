<?php

namespace App\Services;

use App\Models\VacancyType;

class VacancyTypeService
{
    protected $vacancyType;
    public function __construct(VacancyType $vacancyType)
    {
        $this->vacancyType = $vacancyType;
    }

    /**
     * 
     */
    public function index()
    {
        return $this->vacancyType->all();
    }
}
