<?php

namespace Tests\Feature;

use Tests\TestCase;

class CandidateOfferTest extends TestCase
{
    public function test_candidate_offer_page_is_displayed(): void
    {
        $response = $this->get(route('candidate.applications.offer.show'));

        $response
            ->assertOk()
            ->assertSee('Your offer from Meridian Studio')
            ->assertSee('Lead Product Designer')
            ->assertSee('Offer documents')
            ->assertSee('Your offer contact');
    }

    public function test_candidate_can_accept_an_offer_after_reviewing_documents(): void
    {
        $response = $this->post(route('candidate.applications.offer.respond'), [
            'response' => 'accepted',
            'reviewed_documents' => true,
        ]);

        $response
            ->assertRedirect(route('candidate.applications.offer.show'))
            ->assertSessionHas('candidate-offer.response', 'accepted');
    }

    public function test_accepting_an_offer_requires_document_review(): void
    {
        $response = $this
            ->from(route('candidate.applications.offer.show'))
            ->post(route('candidate.applications.offer.respond'), [
                'response' => 'accepted',
            ]);

        $response
            ->assertRedirect(route('candidate.applications.offer.show'))
            ->assertSessionHasErrors('reviewed_documents');
    }

    public function test_candidate_can_save_a_question_about_the_offer(): void
    {
        $response = $this->post(route('candidate.applications.offer.question'), [
            'question' => 'Can we discuss the proposed start date?',
        ]);

        $response
            ->assertRedirect(route('candidate.applications.offer.show'))
            ->assertSessionHas('candidate-offer.last-question', 'Can we discuss the proposed start date?');
    }
}
