<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyMaterialFilterRequest extends FormRequest
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
            'study_material_type'   => 'sometimes|array',
            'study_material_type.*' => 'required_with:study_material_type|numeric|distinct|min:1',

            'author_type'   => 'sometimes|array|min:1',
            'author_type.*' => 'required_with:author_type|numeric|distinct|min:1',

            'created_date_start' => 'nullable|date_format:Y-m-d',
            'created_date_end' => 'nullable|date_format:Y-m-d',

            'category'   => 'sometimes|array',
            'category.*' => 'required_with:category|numeric|distinct|min:1'
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
