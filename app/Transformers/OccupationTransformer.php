<?php

namespace App\Transformers;

use App\Models\Occupation;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class OccupationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Occupation $occupation)
    {
        return [
            'id'        => (int) $occupation->id,
            'name'      => $occupation->name,
            'code'      => $occupation->code,
            'createdAt' => Carbon::parse($occupation->created_at)->format('d/m/Y')
        ];
    }
}
