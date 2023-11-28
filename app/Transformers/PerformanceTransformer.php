<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class PerformanceTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'resumeStatus'
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
    public function transform(User $user)
    {
        return [
            'id'            => (int) $user->id,
            'stamped'       => (bool) $user->stamped,
            'evaluated'     => (bool) $user->evaluated,
            'updatedAtDate' => $user->resume->updated_at->format('d/m/Y'),
            'updatedAtTime' => $user->resume->updated_at->format('H:i')
        ];
    }

    /**
     * 
     */
    public function includeResumeStatus(User $user)
    {
        if (!isset($user->resume) || !isset($user->resume->status)) {
            return null;
        }

        return $this->item($user->resume->status, new ResumeStatusTransformer());
    }
}
