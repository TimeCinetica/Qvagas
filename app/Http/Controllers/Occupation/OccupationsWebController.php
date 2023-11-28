<?php

namespace App\Http\Controllers\Occupation;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertOccupationRequest;
use App\Services\OccupationsService;
use App\Transformers\OccupationTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Facades\Fractal;

class OccupationsWebController extends Controller
{
    protected $occupationService;

    /**
     * 
     */
    public function __construct(OccupationsService $occupationService)
    {
        $this->occupationService = $occupationService;
    }

    /**
     * 
     */
    public function renderOccupations(Request $request)
    {
        $policies = $this->getOccupationsPolicies();
        $occupations = $this->occupationService->indexOccupations($request, false);
        return view('occupations.index', ['occupations' => $occupations, 'policies' => $policies]);
    }


    /**
     * 
     */
    public function edit(UpsertOccupationRequest $request, $id)
    {
        $occupation = $this->occupationService->edit($id, $request);

        $transformer = new OccupationTransformer();
        $occupation = Fractal::item($occupation)
            ->transformWith($transformer)
            ->toArray();

        return response()->json($occupation, 200);
    }

    /**
     * 
     */
    public function store(UpsertOccupationRequest $request)
    {
        $occupation = $this->occupationService->store($request);

        $transformer = new OccupationTransformer();
        $occupation = Fractal::item($occupation)
            ->transformWith($transformer)
            ->toArray();

        return response()->json($occupation, 201);
    }

    /**
     * 
     */
    public function delete($id)
    {
        $this->occupationService->delete($id);
        return response()->noContent();
    }

    /**
     * 
     */
    private function getOccupationsPolicies()
    {
        $isSadmin = auth()->user()->isSadmin();
        return (object) [
            'details' => false,
            'edit'    => $isSadmin,
            'delete'  => $isSadmin
        ];
    }
}
