<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\AskCandidateOfferQuestionRequest;
use App\Http\Requests\Candidate\RespondToCandidateOfferRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateOfferController extends Controller
{
    public function show(): View
    {
        return view('candidate.applications.offer', [
            'offer' => $this->offerDetails(),
            'response' => session('candidate-offer.response'),
        ]);
    }

    public function respond(RespondToCandidateOfferRequest $request): RedirectResponse
    {
        $response = $request->validated('response');

        session()->put('candidate-offer.response', $response);

        return to_route('candidate.applications.offer.show')->with(
            'status',
            $response === 'accepted' ? 'Offer accepted successfully.' : 'Offer declined.'
        );
    }

    public function askQuestion(AskCandidateOfferQuestionRequest $request): RedirectResponse
    {
        session()->put('candidate-offer.last-question', $request->validated('question'));

        return to_route('candidate.applications.offer.show')
            ->with('status', 'Your question has been saved for Jamie.');
    }

    /**
     * @return array<string, mixed>
     */
    private function offerDetails(): array
    {
        return [
            'company' => 'Meridian Studio',
            'title' => 'Lead Product Designer',
            'reference' => 'MS-108',
            'received_at' => 'October 19, 2026',
            'review_deadline' => 'October 28',
            'workplace' => 'Remote',
            'country' => 'United States',
            'employment_type' => 'Full-time',
            'start_date' => 'November 16, 2026',
            'contact' => [
                'name' => 'Jamie Rivera',
                'role' => 'Assigned agency recruiter',
            ],
            'compensation' => [
                ['label' => 'Base salary', 'details' => '$165,000 USD'],
                ['label' => 'Target annual bonus', 'details' => '10% of base · subject to plan terms'],
                ['label' => 'Equity', 'details' => 'Grant details in the offer letter'],
                ['label' => 'Benefits', 'details' => 'Medical, dental, vision, retirement, learning budget'],
            ],
            'documents' => [
                ['name' => 'Meridian_Offer_Maya_Chen.pdf', 'status' => 'Ready for review', 'action' => 'Open document ↗'],
                ['name' => 'Benefits_Overview_2026.pdf', 'status' => 'Reference', 'action' => 'Download ↗'],
            ],
        ];
    }
}
