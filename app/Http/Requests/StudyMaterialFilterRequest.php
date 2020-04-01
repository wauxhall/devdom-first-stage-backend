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
            'searchword' => 'nullable|min:1',

            'study_material_type_ids'   => 'sometimes|array',
            'study_material_type_ids.*' => 'required_with:study_material_type|numeric|distinct|min:1',

            'author_type_ids'   => 'sometimes|array|min:1',
            'author_type_ids.*' => 'required_with:author_type|numeric|distinct|min:1',

            'created_date_start' => 'nullable|date_format:Y-m-d',
            'created_date_end' => 'nullable|date_format:Y-m-d',

            'category_ids'   => 'sometimes|array',
            'category_ids.*' => 'required_with:category|numeric|distinct|min:1'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'searchword.min' => 'Поисковое слово должно быть длиннее 3 символов'
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
