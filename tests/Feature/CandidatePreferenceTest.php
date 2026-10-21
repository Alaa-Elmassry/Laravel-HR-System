<?php

namespace Tests\Feature;

use Tests\TestCase;

class CandidatePreferenceTest extends TestCase
{
    public function test_candidate_preferences_page_is_displayed(): void
    {
        $response = $this->get(route('candidate.preferences.show'));

        $response
            ->assertOk()
            ->assertSee('Job preferences &amp; alerts', false)
            ->assertSee('Your next role')
            ->assertSee('Privacy controls')
            ->assertSee('Saved-search alert');
    }

    public function test_candidate_preferences_can_be_saved_in_the_session(): void
    {
        $response = $this->put(route('candidate.preferences.update'), $this->validPreferences());

        $response
            ->assertRedirect(route('candidate.preferences.show'))
            ->assertSessionHas('candidate-preferences.values.location', 'Cairo, Egypt')
            ->assertSessionHas('candidate-preferences.values.minimum_salary', 90000)
            ->assertSessionHas('candidate-preferences.values.desired_titles', [
                'Product Designer',
                'UX Designer',
            ]);
    }

    public function test_candidate_preferences_validation_rejects_invalid_input(): void
    {
        $preferences = $this->validPreferences();
        $preferences['desired_titles'] = '';
        $preferences['employment_type'] = 'unknown';
        $preferences['minimum_salary'] = -1;

        $response = $this
            ->from(route('candidate.preferences.show'))
            ->put(route('candidate.preferences.update'), $preferences);

        $response
            ->assertRedirect(route('candidate.preferences.show'))
            ->assertSessionHasErrors(['desired_titles', 'employment_type', 'minimum_salary']);
    }

    public function test_saved_search_alert_can_be_updated(): void
    {
        $response = $this->put(route('candidate.preferences.saved-search.update'), [
            'name' => 'Remote product design',
            'frequency' => 'Daily',
            'schedule' => 'Every day at 8:00 AM',
            'email' => 'maya@example.com',
        ]);

        $response
            ->assertRedirect(route('candidate.preferences.show'))
            ->assertSessionHas('candidate-preferences.saved-search.frequency', 'Daily');
    }

    /**
     * @return array<string, mixed>
     */
    private function validPreferences(): array
    {
        return [
            'desired_titles' => 'Product Designer, UX Designer',
            'location' => 'Cairo, Egypt',
            'employment_type' => 'full-time',
            'currency' => 'USD',
            'minimum_salary' => 90000,
            'work_model' => 'remote',
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
}
