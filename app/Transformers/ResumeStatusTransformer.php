<?php

namespace App\Transformers;

use App\Models\ResumeStatus;
use League\Fractal\TransformerAbstract;

class ResumeStatusTransformer extends TransformerAbstract
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
    public function transform(ResumeStatus $status)
    {
        return [
            'id'          => (int) $status->id,
            'name'        => $status->name,
            'description' => $status->description
        ];
    }
}
