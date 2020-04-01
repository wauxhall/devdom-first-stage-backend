<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyMaterialLinkCreateRequest extends FormRequest
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
            'links'             => 'required|array',
            'links.*'           => 'required|array',
            'links.*.study_material_id' => 'required|numeric|min:1|exists:study_materials,id',
            'links.*.link'      => 'required|string|min:3'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'links.*.link.min'   => 'Ссылка должна быть длиннее 3 символов',
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
