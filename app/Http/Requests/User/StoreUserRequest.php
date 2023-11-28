<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => ['required'],
            'cpf'               => ['required', 'unique:users'],
            'email'             => ['required', 'email', 'unique:users'],
            'password'          => ['required', 'min:6'],
            'birthDate'         => ['required', 'date'],
            'cellphone'         => ['required', 'unique:users'],
            'cellphone2'        => ['nullable'],
            'schooling'         => ['required'],
            'cep'               => ['required'],
            'address'           => ['required'],
            'number'            => ['required'],
            'district'          => ['required'],
            'cityId'            => ['required'],
            'stateId'           => ['required'],
            'sex'               => ['required', 'integer'],
            'otherSex'          => ['nullable'],
            'rg'                => ['required'],
            'rgStateId'         => ['required'],
            'father'            => ['nullable'],
            'mother'            => ['required'],
            'civil'             => ['required', 'integer'],
            'otherCivil'        => ['nullable'],
            'volunteerWork'     => ['required', 'integer', 'in:1,2'],
            'otherVolunteerWork' => ['nullable'],
            'hasChildren'       => ['required', 'integer'],
            'raceId'            => ['required', 'integer'],
            'otherHasChildren'  => ['nullable'],
            'whoHelps'          => ['nullable'],
            'accident'          => ['nullable'],
            'smoke'             => ['nullable'],
            'timeAvailability'  => ['nullable'],
            'workWeekends'      => ['nullable'],
            'missWork'          => ['nullable'],
            'hobbies'           => ['nullable'],
            'availableTravel'   => ['required', 'integer', 'in:1,2'],
            'linkedin'          => ['nullable'],
            'lattes'            => ['nullable'],
            'video'             => ['nullable'],
            'occupationArea'    => ['required'],
            'vacancyTypeId'     => ['required'],
            'salary'            => ['nullable'],
            'typeWorking'       => ['required', 'integer'],
            'typeContract'      => ['required', 'integer'],
            'courses'           => ['nullable'],
            'firstJob'          => ['nullable'],
            'unemployedTime'    => ['nullable'],
            'laborActivity'     => ['nullable'],
            'targetJob'         => ['nullable'],
            'lastSalary'        => ['nullable'],
            'abstract'          => ['nullable'],
            'reference'         => ['nullable'],
            'companyName'       => ['nullable'],
            'resumeCompanies'   => ['nullable', 'array'],
            'resumeLanguagues'  => ['nullable', 'array']
        ];
    }
}
