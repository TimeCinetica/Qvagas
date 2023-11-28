<?php

namespace App\Services;

use App\Http\Requests\UpsertOccupationRequest;
use App\Models\Occupation;
use Illuminate\Http\Request;

class OccupationsService
{
    protected $occupation;

    public function __construct(Occupation $occupation)
    {
        $this->occupation = $occupation;
    }

    /**
     * 
     */
    public function indexOccupations(Request $request, $all = true)
    {
        if ($all) {
            return $this->occupation->all();
        }

        $query = $this->occupationQueryFilter($request);

        $occupations = $query->paginate(10);

        return $occupations;
    }

    /**
     * 
     */
    public function store(UpsertOccupationRequest $request)
    {
        $this->validateOccupation($request);
        $request->merge(['code' => '0000']);
        $occupation = $this->occupation->create($request->all());

        return $occupation;
    }

    /**
     * 
     */
    public function edit($id, UpsertOccupationRequest $request)
    {
        $this->validateOccupation($request);
        $occupation = $this->occupation->findOrFail($id);
        $occupation->update($request->all());

        return $occupation;
    }

    /**
     * 
     */
    public function delete($id)
    {
        $this->occupation->destroy($id);
        return;
    }

    /**
     * @param UpsertOccupationRequest $request
     * @return void
     */
    private function validateOccupation($request)
    {
        $notUnique = $this->occupation->where('name', $request->name)->first();
        if (isset($notUnique)) {
            abort(400, "Profissão com esse nome já cadastrada");
        }
    }

    /**
     * 
     */
    private function occupationQueryFilter($request)
    {
        $query = $this->occupation->query();

        if ($request->has('name')) {
            $query->orderBy('name', $request->name);
        } else {
            $query->orderBy('name', 'asc');
        }

        if (isset($request->search)) {
            $name = trim($request->search);
            $query->where('name', 'like', '%' . $name . '%');
        }


        return $query;
    }
}
