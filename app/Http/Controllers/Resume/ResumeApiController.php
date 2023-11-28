<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Services\ResumeService;
use Illuminate\Http\Request;

class ResumeApiController extends Controller
{
    protected $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }
}
