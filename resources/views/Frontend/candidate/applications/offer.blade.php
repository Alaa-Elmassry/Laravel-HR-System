@extends('layouts.app')

@section('title', 'Your Offer from Meridian Studio | Hirebridge')

@section('content')
    <div class="offer-page container-fluid px-0">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Please check your response:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success" role="status">{{ session('status') }}</div>
        @endif

        <div class="profile-breadcrumb">24 / My workspace / My applications</div>

        <header class="offer-heading">
            <h1>Your offer from {{ $offer['company'] }}</h1>
            <p>{{ $offer['title'] }} · {{ $offer['reference'] }} · Offer received {{ $offer['received_at'] }}</p>
        </header>

        <section class="offer-deadline" aria-label="Offer deadline">
            <strong>Review your offer by {{ $offer['review_deadline'] }}</strong>
            <span>This is a separate Meridian Studio application. Your Northstar Labs application remains at Interview.</span>
        </section>

        <div class="offer-statuses" aria-label="Offer status">
            <span class="offer-status offer-status-waiting"><i></i>{{ $response ? ucfirst($response) : 'Awaiting your response' }}</span>
            <span class="offer-status"><i></i>Agency-managed</span>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-xl-9 col-lg-8">
                <section class="profile-card offer-summary-card">
                    <h2>A new chapter at Meridian</h2>
                    <h3>{{ $offer['title'] }}</h3>
                    <p class="offer-meta">
                        {{ $offer['workplace'] }} · {{ $offer['country'] }} · {{ $offer['employment_type'] }}<br>
                        Proposed start date: {{ $offer['start_date'] }}
                    </p>

                    <div class="offer-compensation">
                        @foreach ($offer['compensation'] as $item)
                            <div class="offer-compensation-item">
                                <span>{{ $item['label'] }}</span>
                                <p>Annual value / details: {{ $item['details'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <p class="offer-fine-print">The signed offer letter governs all terms. Bonus and equity are not guaranteed cash compensation.</p>
                </section>

                <section class="profile-card offer-documents-card mt-4" id="offer-documents">
                    <h2>Offer documents</h2>

                    <div class="offer-document-list">
                        @foreach ($offer['documents'] as $document)
                            <article class="offer-document">
                                <strong>{{ $document['name'] }}</strong>
                                <p>Status: {{ $document['status'] }} <span>·</span> Action: <a href="#offer-documents">{{ $document['action'] }}</a></p>
                            </article>
                        @endforeach
                    </div>

                    <label class="form-check profile-check offer-reviewed-check">
                        <input class="form-check-input" type="checkbox" value="1" data-reviewed-documents @checked($response === 'accepted')>
                        <span class="form-check-label">I have reviewed the offer documents</span>
                    </label>

                    <div class="offer-actions">
                        <button class="btn btn-primary" type="button" data-accept-offer data-bs-toggle="modal" data-bs-target="#acceptOfferModal">
                            Accept offer
                        </button>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#questionOfferModal">
                            Ask a question
                        </button>
                        <button class="btn btn-link offer-decline-button" type="button" data-bs-toggle="modal" data-bs-target="#declineOfferModal">
                            Decline offer
                        </button>
                    </div>

                    <p class="offer-action-note">Accepting opens a confirmation step before recording your response. No decision has been submitted.</p>
                </section>

                <footer class="profile-footer">
                    Hirebridge · Private workspace · All times Central unless noted · October 20, 2026
                </footer>
            </div>

            <div class="col-xl-3 col-lg-4">
                <aside class="profile-card profile-side-card offer-contact-card">
                    <h2>Your offer contact</h2>
                    <p><strong>{{ $offer['contact']['name'] }}</strong><br>{{ $offer['contact']['role'] }}</p>
                    <p>Questions about compensation, timing, or terms? Send a message before the response deadline.</p>
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#questionOfferModal">
                        Message Jamie
                    </button>
                </aside>

                <aside class="profile-card profile-side-card offer-after-card mt-4">
                    <h2>After you accept</h2>
                    <p class="offer-preview-status"><i></i>Preview · Not started</p>
                    <ol>
                        <li>Confirm and sign your offer</li>
                        <li>Complete company checks</li>
                        <li>Share onboarding details</li>
                        <li>Meet your Meridian team</li>
                    </ol>
                    <p class="mb-0">Onboarding only starts after your confirmed acceptance.</p>
                </aside>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="acceptOfferModal" tabindex="-1" aria-labelledby="acceptOfferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.applications.offer.respond') }}" method="POST">
                @csrf
                <input type="hidden" name="response" value="accepted">
                <input type="hidden" name="reviewed_documents" value="1">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="acceptOfferModalLabel">Confirm offer acceptance</h2>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You are accepting the {{ $offer['title'] }} offer from {{ $offer['company'] }}.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Confirm acceptance</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="declineOfferModal" tabindex="-1" aria-labelledby="declineOfferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.applications.offer.respond') }}" method="POST">
                @csrf
                <input type="hidden" name="response" value="declined">
                <input type="hidden" name="reviewed_documents" value="0">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="declineOfferModalLabel">Decline this offer?</h2>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Your response will be recorded as declined.</div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Keep offer</button>
                    <button class="btn btn-outline-danger" type="submit">Confirm decline</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="questionOfferModal" tabindex="-1" aria-labelledby="questionOfferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.applications.offer.question') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="questionOfferModalLabel">Ask Jamie a question</h2>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label" for="offer_question">Your question</label>
                    <textarea class="form-control" id="offer_question" name="question" rows="5" maxlength="2000" required>{{ old('question') }}</textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save question</button>
                </div>
            </form>
        </div>
    </div>
@endpush
