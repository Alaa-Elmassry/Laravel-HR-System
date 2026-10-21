<?php

namespace Tests\Feature;

use Tests\TestCase;

class CandidateProfileTest extends TestCase
{
    public function test_candidate_profile_page_is_displayed(): void
    {
        $response = $this->get(route('candidate.profile.show'));

        $response
            ->assertOk()
            ->assertSee('Profile &amp; resume', false)
            ->assertSee('Maya Chen')
            ->assertSee('Visibility &amp; consent', false);
    }

    public function test_candidate_profile_details_can_be_saved_in_the_session(): void
    {
        $response = $this->put(route('candidate.profile.update'), [
            'headline' => 'Lead Product Designer',
            'location' => 'Cairo, Egypt',
            'bio' => 'A product designer focused on clear, accessible experiences.',
            'portfolio_url' => 'https://example.com/portfolio',
        ]);

        $response
            ->assertRedirect(route('candidate.profile.show'))
            ->assertSessionHas('candidate-profile.profile.headline', 'Lead Product Designer')
            ->assertSessionHas('candidate-profile.profile.location', 'Cairo, Egypt');
    }

    public function test_candidate_profile_validation_rejects_invalid_input(): void
    {
        $response = $this->from(route('candidate.profile.show'))->put(route('candidate.profile.update'), [
            'headline' => '',
            'location' => '',
            'bio' => '',
            'portfolio_url' => 'not-a-url',
        ]);

        $response
            ->assertRedirect(route('candidate.profile.show'))
            ->assertSessionHasErrors(['headline', 'location', 'bio', 'portfolio_url']);
    }
}
