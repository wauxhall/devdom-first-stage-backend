<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyMaterialCategoryCreateRequest extends FormRequest
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
            'parent_id' => 'nullable|numeric|min:1|exists:study_material_categories,id',
            'name'      => 'required|min:3'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Название категории обязательно',
            'name.min'      => 'Название категории должно быть длиннее 3 символов'
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
