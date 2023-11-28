<?php

namespace App\Http\Controllers\Occupation;

use App\Http\Controllers\Controller;
use App\Services\OccupationsService;
use Illuminate\Http\Request;

class OccupationsApiController extends Controller
{
    protected $occupationService;

    public function __construct(OccupationsService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    /**
     * 
     */
    public function indexOccupations(Request $request)
    {
        $occupations = $this->occupationService->indexOccupations($request);
        return response()->json($occupations, 200);
    }

    /**
     * 
     */
    public function indexFilteredOccupations(Request $request)
    {
        $occupations = $this->occupationService->indexOccupations($request, false);
        return response()->json($occupations, 200);
    }
}
