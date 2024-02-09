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
            'updatedAtDate' => $user->resume ? $user->resume->updated_at->format('d/m/Y') : null,
            'updatedAtTime' => $user->resume ? $user->resume->updated_at->format('H:i') : null
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
