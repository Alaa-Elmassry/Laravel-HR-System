@extends('layouts.app')

@section('title', 'Job Preferences & Alerts | Hirebridge')

@section('content')
    <div class="preferences-page container-fluid px-0">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Please check the form:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-breadcrumb">23 / My workspace / Preferences &amp; alerts</div>

        <div class="preferences-heading">
            <h1>Job preferences &amp; alerts</h1>
            <p>Shape your recommendations. Choose what reaches your inbox.</p>
        </div>

        <div class="preferences-saved-alert" role="status">
            <strong>{{ session('status', 'Preferences saved') }}</strong>
            <span>Updated {{ $lastSaved }}. New recommendations use these preferences.</span>
        </div>

        <form action="{{ route('candidate.preferences.update') }}" method="POST" data-preferences-form>
            @csrf
            @method('PUT')

            <div class="row g-4 align-items-start mt-0">
                <div class="col-xl-9 col-lg-8">
                    <section class="profile-card preference-card">
                        <h2>Your next role</h2>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="profile-field">
                                    <span>Desired titles</span>
                                    <input type="text" name="desired_titles" value="{{ old('desired_titles', implode(', ', $preferences['desired_titles'])) }}" maxlength="500">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field">
                                    <span>Location</span>
                                    <input type="text" name="location" value="{{ old('location', $preferences['location']) }}" maxlength="255">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field">
                                    <span>Employment type</span>
                                    <select name="employment_type">
                                        @foreach ($employmentTypes as $value => $label)
                                            <option value="{{ $value }}" @selected(old('employment_type', $preferences['employment_type']) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="profile-field salary-field">
                                    <span>Minimum base salary</span>
                                    <div>
                                        <select name="currency" aria-label="Salary currency">
                                            @foreach (['USD', 'EUR', 'GBP', 'EGP'] as $currency)
                                                <option value="{{ $currency }}" @selected(old('currency', $preferences['currency']) === $currency)>{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="minimum_salary" value="{{ old('minimum_salary', $preferences['minimum_salary']) }}" min="0" max="10000000" step="1000" aria-label="Minimum annual salary">
                                        <b>/ year</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field">
                                    <span>Preferred work model</span>
                                    <select name="work_model">
                                        @foreach ($workModels as $value => $label)
                                            <option value="{{ $value }}" @selected(old('work_model', $preferences['work_model']) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="preference-checks mt-3">
                            <input type="hidden" name="include_agency_opportunities" value="0">
                            <label class="form-check profile-check">
                                <input class="form-check-input" type="checkbox" name="include_agency_opportunities" value="1" @checked(old('include_agency_opportunities', $preferences['include_agency_opportunities']))>
                                <span class="form-check-label">Include agency-managed opportunities</span>
                            </label>

                            <input type="hidden" name="willing_to_relocate" value="0">
                            <label class="form-check profile-check mb-0">
                                <input class="form-check-input" type="checkbox" name="willing_to_relocate" value="1" @checked(old('willing_to_relocate', $preferences['willing_to_relocate']))>
                                <span class="form-check-label">Willing to relocate</span>
                            </label>
                        </div>
                    </section>

                    <section class="profile-card preference-card mt-4">
                        <h2>Notifications</h2>

                        @foreach ($notificationOptions as $field => $label)
                            <input type="hidden" name="{{ $field }}" value="0">
                            <label class="form-check profile-check">
                                <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $preferences[$field]))>
                                <span class="form-check-label">{{ $label }}</span>
                            </label>
                        @endforeach

                        <p class="notification-note">Security and account-access emails are always sent.</p>
                    </section>

                    <div class="preferences-actions">
                        <button class="btn btn-primary" type="submit">Save preferences</button>
                        <button class="btn btn-outline-primary" type="button" data-cancel-preferences>Cancel changes</button>
                        <span class="unsaved-indicator" data-unsaved-indicator>Unsaved changes</span>
                    </div>

                    <footer class="profile-footer">
                        Hirebridge · Private workspace · All times Central unless noted · October 20, 2026
                    </footer>
                </div>

                <div class="col-xl-3 col-lg-4">
                    <aside class="profile-card profile-side-card">
                        <h2>Privacy controls</h2>

                        @foreach ($privacyOptions as $field => $label)
                            <input type="hidden" name="{{ $field }}" value="0">
                            <label class="form-check profile-check">
                                <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $preferences[$field]))>
                                <span class="form-check-label">{{ $label }}</span>
                            </label>
                        @endforeach

                        <p class="visibility-note mb-0">Your preferences are used to suggest relevant roles. Other employers cannot see where you have applied.</p>
                    </aside>

                    <aside class="profile-card profile-side-card saved-search-card mt-4">
                        <h2>Saved-search alert</h2>
                        <p>{{ $savedSearch['name'] }}</p>
                        <p>{{ $savedSearch['frequency'] }} · {{ $savedSearch['schedule'] }}<br>Sent to {{ $savedSearch['email'] }}</p>

                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#savedSearchModal">
                            Manage saved searches
                        </button>
                    </aside>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="savedSearchModal" tabindex="-1" aria-labelledby="savedSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.preferences.saved-search.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="savedSearchModalLabel">Manage saved-search alert</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="saved_search_name">Search name</label>
                        <input class="form-control" id="saved_search_name" name="name" value="{{ $savedSearch['name'] }}" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="frequency">Frequency</label>
                        <select class="form-select" id="frequency" name="frequency">
                            @foreach (['Daily', 'Weekly', 'Monthly'] as $frequency)
                                <option value="{{ $frequency }}" @selected($savedSearch['frequency'] === $frequency)>{{ $frequency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="schedule">Delivery schedule</label>
                        <input class="form-control" id="schedule" name="schedule" value="{{ $savedSearch['schedule'] }}" required maxlength="255">
                    </div>
                    <div>
                        <label class="form-label" for="alert_email">Email</label>
                        <input class="form-control" id="alert_email" type="email" name="email" value="{{ $savedSearch['email'] }}" required maxlength="255">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save alert</button>
                </div>
            </form>
        </div>
    </div>
@endpush
