<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateEducationSkillsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'degree' => ['nullable', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'start_year' => ['required', 'integer', 'min:1950', 'max:2100'],
            'graduation_year' => ['required', 'integer', 'gte:start_year', 'max:2100'],
            'skills' => ['required', 'string', 'max:500'],
        ];
    }
}
