<?php

namespace Modules\Company\Http\Requests\V1;

use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends BaseCompanyRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name'     => [
                'sometimes',
                'string',
                // add unique validation rule where name and user_id combo is unique
                Rule::unique('companies', 'name')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                })->ignore($this->route('company')),
            ],
            'data.attributes.location' => ['sometimes', 'string'],
        ];
    }
}
