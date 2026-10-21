<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RespondToCandidateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'response' => ['required', Rule::in(['accepted', 'declined'])],
            'reviewed_documents' => ['required_if:response,accepted', 'boolean'],
        ];
    }
}
