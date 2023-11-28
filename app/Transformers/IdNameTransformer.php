<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class IdNameTransformer extends TransformerAbstract
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
    public function transform($obj)
    {
        return [
            'id'    => $obj->id,
            'name'  => $obj->name
        ];
    }
}
