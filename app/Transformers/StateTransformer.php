<?php

namespace App\Transformers;

use App\Models\State;
use League\Fractal\TransformerAbstract;

class StateTransformer extends TransformerAbstract
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
    public function transform(State $state)
    {
        return [
            'id'    => (int) $state->id,
            'name'  => $state->name,
            'abbr'  => $state->abbr,
        ];
    }
}
