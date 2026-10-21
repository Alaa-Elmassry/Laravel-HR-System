<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateVisibilityRequest extends FormRequest
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
            'applied_employers_only' => ['required', 'boolean'],
            'allow_recruiter_requests' => ['required', 'boolean'],
            'public_search' => ['required', 'boolean'],
        ];
    }
}
