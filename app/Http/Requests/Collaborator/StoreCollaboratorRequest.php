<?php

namespace App\Http\Requests\Collaborator;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollaboratorRequest extends FormRequest
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
            'admin_responsed'       => [],
            'name'                  => ['required'],
            'cpf'                   => ['required', 'unique:users'],
            'email'                 => ['required', 'email', 'unique:users'],
            'cellphone'             => [],
            'birthDate'             => [], ['date'],
            'job'                   => [],
            'roleId'                => ['required', 'in:1,2,4'],
            'password'              => ['required', 'min:6'],
        ];
    }
}
