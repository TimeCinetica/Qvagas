<?php

namespace App\Transformers;

use App\Models\User;

class UserTransformer extends BaseTransformer
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
        'resume',
        'role',
        'race',
        'state',
        'city',
        'rgState'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'                 => (int) $user->id,
            'name'               => $user->name,
            'email'              => $user->email,
            'roleId'             => (int) $user->roleId,
            'cpf'                => $user->cpf,
            'birthDate'          => $this->formatDate($user->birthDate),
            'cellphone'          => $user->cellphone,
            'cellphone2'         => $user->cellphone2,
            'schooling'          => $user->schooling,
            'cep'                => $user->cep,
            'address'            => $user->address,
            'number'             => $user->number,
            'district'           => $user->district,
            'city'               => $user->city,
            'stateId'            => $user->stateId,
            'sex'                => (int) $user->sex,
            'otherSex'           => $user->otherSex,
            'rg'                 => $user->rg,
            'rgStateId'          => $user->rgStateId,
            'father'             => $user->father,
            'mother'             => $user->mother,
            'civil'              => (int) $user->civil,
            'otherCivil'         => $user->otherCivil,
            'volunteerWork'      => (int) $user->volunteerWork,
            'otherVolunteerWork' => $user->otherVolunteerWork,
            'hasChildren'        => (int) $user->hasChildren,
            'otherHasChildren'   => $user->otherHasChildren,
            'whoHelps'           => $user->whoHelps,
            'accident'           => $user->accident,
            'smoke'              => $user->smoke,
            'timeAvailability'   => $user->timeAvailability,
            'workWeekends'       => $user->workWeekends,
            'missWork'           => $user->missWork,
            'hobbies'            => $user->hobbies,
            'availableTravel'    => (int) $user->availableTravel,
            'photo'              => $this->formatFileUrl($user->photo),
            'evaluated'          => (bool) $user->evaluated,
            'stamped'            => (bool) $user->stamped,
            'raceId'             => (int) $user->raceId,
            'pcdReport'          => $this->formatFileUrl($user->pcdReport),
            'createdAt'          => $this->formatDate($user->created_at)
        ];
    }

    /**
     * 
     */
    public function includeResume(User $user)
    {
        if (!isset($user->resume)) {
            return null;
        }

        return $this->item($user->resume, new ResumeTransformer());
    }

    /**
     * 
     */
    public function includeRole(User $user)
    {
        if (!isset($user->role)) {
            return null;
        }

        return $this->item($user->role, new IdNameTransformer());
    }

    /**
     * 
     */
    public function includeRace(User $user)
    {
        if (!isset($user->race)) {
            return null;
        }

        return $this->item($user->race, new IdNameTransformer());
    }

    /**
     * 
     */
    public function includeState(User $user)
    {
        if (!isset($user->state)) {
            return null;
        }

        return $this->item($user->state, new StateTransformer());
    }

    /**
     * 
     */
    public function includeCity(User $user)
    {
        if (!isset($user->city)) {
            return null;
        }

        return $this->item($user->city, new IdNameTransformer());
    }

    /**
     * 
     */
    public function includeRgState(User $user)
    {
        if (!isset($user->rgState)) {
            return null;
        }

        return $this->item($user->rgState, new StateTransformer());
    }
}
