<?php

namespace App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserFilesRequest extends FormRequest
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
            'personalPhoto' => ['nullable'],
            'curriculumPhoto' => ['nullable'],
            'recomendationPhoto' => ['nullable'],
            'pcdReport'         => ['nullable'],
        ];
    }
}
