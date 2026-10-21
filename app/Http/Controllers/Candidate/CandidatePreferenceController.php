<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\UpdateCandidatePreferencesRequest;
use App\Http\Requests\Candidate\UpdateCandidateSavedSearchAlertRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidatePreferenceController extends Controller
{
    public function show(): View
    {
        return view('candidate.preferences.index', [
            'preferences' => session('candidate-preferences.values', $this->defaultPreferences()),
            'savedSearch' => session('candidate-preferences.saved-search', $this->defaultSavedSearch()),
            'lastSaved' => session('candidate-preferences.saved-at', 'October 20 at 8:45 AM'),
            'employmentTypes' => [
                'full-time' => 'Full-time',
                'part-time' => 'Part-time',
                'contract' => 'Contract',
                'internship' => 'Internship',
            ],
            'workModels' => [
                'remote' => 'Remote',
                'hybrid-remote' => 'Hybrid + Remote',
                'hybrid' => 'Hybrid',
                'on-site' => 'On-site',
            ],
            'notificationOptions' => [
                'weekly_job_digest' => 'Weekly personalized job digest',
                'application_status_updates' => 'Application status updates · Email and in-app',
                'interview_reminders' => 'Interview reminders · 24 hours and 1 hour before',
                'hiring_team_messages' => 'New hiring-team messages · Email and in-app',
                'product_marketing' => 'Product news and marketing',
            ],
            'privacyOptions' => [
                'share_profile_on_approval' => 'Share profile only when I apply or approve access',
                'allow_recruiter_contact' => 'Allow recruiter contact requests',
                'share_salary_publicly' => 'Share salary preferences on public profile',
            ],
        ]);
    }

    public function update(UpdateCandidatePreferencesRequest $request): RedirectResponse
    {
        $preferences = $request->validated();
        $preferences['desired_titles'] = collect(explode(',', $preferences['desired_titles']))
            ->map(fn (string $title): string => trim($title))
            ->filter()
            ->unique()
            ->values()
            ->all();

        session()->put('candidate-preferences.values', $preferences);
        session()->put('candidate-preferences.saved-at', now()->format('F j \a\t g:i A'));

        return to_route('candidate.preferences.show')->with('status', 'Preferences saved');
    }

    public function updateSavedSearch(UpdateCandidateSavedSearchAlertRequest $request): RedirectResponse
    {
        session()->put('candidate-preferences.saved-search', $request->validated());

        return to_route('candidate.preferences.show')->with('status', 'Saved-search alert updated');
    }

    /**
     * @return array<string, mixed>
     */
    private function defaultPreferences(): array
    {
        return [
            'desired_titles' => ['Senior Product Designer', 'Lead Product Designer'],
            'location' => 'Austin, TX + Remote US',
            'employment_type' => 'full-time',
            'currency' => 'USD',
            'minimum_salary' => 140000,
            'work_model' => 'hybrid-remote',
            'include_agency_opportunities' => true,
            'willing_to_relocate' => false,
            'weekly_job_digest' => true,
            'application_status_updates' => true,
            'interview_reminders' => true,
            'hiring_team_messages' => true,
            'product_marketing' => false,
            'share_profile_on_approval' => true,
            'allow_recruiter_contact' => true,
            'share_salary_publicly' => false,
        ];
    }

    /**
     * @return array<string, string>
     */
    private function defaultSavedSearch(): array
    {
        return [
            'name' => 'Senior design · Austin + Remote',
            'frequency' => 'Weekly',
            'schedule' => 'Mondays at 9:00 AM Central',
            'email' => 'maya.chen@example.com',
        ];
    }
}
