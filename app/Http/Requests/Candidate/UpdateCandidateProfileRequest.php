<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateProfileRequest extends FormRequest
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
            'headline' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:5000'],
            'portfolio_url' => ['nullable', 'url:http,https', 'max:2048'],
        ];
    }
}
