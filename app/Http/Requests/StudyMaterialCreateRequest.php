<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyMaterialCreateRequest extends FormRequest
{
    public $errors = [];

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
            'study_material_type' => 'required|numeric|min:1|exists:study_material_types,id',
            'author_type'         => 'required|numeric|min:1|exists:author_types,id',
            'name'                => 'required|string|min:3',
            'description'         => 'nullable|string',
            'links'               => 'sometimes|array',
            'links.*'             => 'required_with:links|string|min:3'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Название учебного материала обязательно',
            'name.min'      => 'Название учебного материала должно быть длиннее 3 символов',
            'name.string'   => 'Название учебного материала должно быть строкой',
            'links.*.min'   => 'Ссылка должна быть длиннее 3 символов',
        ];
    }

    /**
     * Redeclare failed validation method
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) : void
    {
        $this->errors = $validator->errors()->toArray();
    }
}
