<?php

namespace App\Http\Requests\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCandidatePreferencesRequest extends FormRequest
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
            'desired_titles' => ['required', 'string', 'max:500'],
            'location' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', Rule::in(['full-time', 'part-time', 'contract', 'internship'])],
            'currency' => ['required', Rule::in(['USD', 'EUR', 'GBP', 'EGP'])],
            'minimum_salary' => ['required', 'integer', 'min:0', 'max:10000000'],
            'work_model' => ['required', Rule::in(['remote', 'hybrid-remote', 'hybrid', 'on-site'])],
            'include_agency_opportunities' => ['required', 'boolean'],
            'willing_to_relocate' => ['required', 'boolean'],
            'weekly_job_digest' => ['required', 'boolean'],
            'application_status_updates' => ['required', 'boolean'],
            'interview_reminders' => ['required', 'boolean'],
            'hiring_team_messages' => ['required', 'boolean'],
            'product_marketing' => ['required', 'boolean'],
            'share_profile_on_approval' => ['required', 'boolean'],
            'allow_recruiter_contact' => ['required', 'boolean'],
            'share_salary_publicly' => ['required', 'boolean'],
        ];
    }
}
