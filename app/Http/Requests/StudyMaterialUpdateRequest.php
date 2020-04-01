<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyMaterialUpdateRequest extends FormRequest
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
            'study_material_type_id' => 'nullable|numeric|min:1|exists:study_material_types,id',
            'author_type_id'         => 'nullable|numeric|min:1|exists:author_types,id',
            'name'                => 'nullable|string|min:3',
            'description'         => 'nullable|string',
            'links'               => 'sometimes|array',
            'links.*'             => 'required_with:links|array',
            'links.*.id'          => 'required_with:links|numeric|min:1|exists:study_material_links,id',
            'links.*.link'        => 'required_with:links|string|min:3',
            'category_ids'        => 'sometimes|array',
            'category_ids.*'      => 'required_with:category_ids|numeric|min:1|exists:study_material_categories,id'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
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
