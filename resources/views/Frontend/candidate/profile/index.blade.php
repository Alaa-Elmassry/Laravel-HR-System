@extends('layouts.app')

@section('title', 'Profile & Resume | Hirebridge')

@section('content')
    <div class="profile-page container-fluid px-0">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <div class="profile-breadcrumb">22 / My workspace / Profile &amp; resume</div>

        <div class="profile-heading d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-3">
            <div>
                <h1>Profile &amp; resume</h1>
                <p>Your experience, in your own words. Keep it current and control who sees it.</p>
            </div>

            <button class="btn btn-primary profile-preview-btn" type="button" data-bs-toggle="modal" data-bs-target="#profilePreviewModal">
                Preview profile
            </button>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-xl-9 col-lg-8">
                <section class="profile-card">
                    <h2>Profile basics</h2>
                    <p class="profile-name">{{ $profile['name'] }}</p>
                    <p class="profile-summary-line">{{ $profile['headline'] }} · {{ $profile['location'] }}</p>

                    <form action="{{ route('candidate.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="profile-field">
                                    <span>Headline</span>
                                    <input type="text" name="headline" value="{{ old('headline', $profile['headline']) }}" maxlength="255">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="profile-field">
                                    <span>Location</span>
                                    <input type="text" name="location" value="{{ old('location', $profile['location']) }}" maxlength="255">
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="profile-field profile-field-tall">
                                    <span>About you</span>
                                    <textarea name="bio" maxlength="5000" rows="4">{{ old('bio', $profile['bio']) }}</textarea>
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="profile-field">
                                    <span>Portfolio</span>
                                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $profile['portfolio_url']) }}" maxlength="2048">
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-3" type="submit">Save profile</button>
                    </form>
                </section>

                <section class="profile-card mt-4">
                    <h2>Experience</h2>

                    <div class="experience-list">
                        @foreach ($experiences as $experience)
                            <article class="experience-item">
                                <p class="experience-title">{{ $experience['job_title'] }} · {{ $experience['company_name'] }}</p>
                                <p>{{ $experience['start_label'] }}–{{ $experience['end_label'] }} · {{ $experience['place'] }}</p>
                                <p class="experience-description">{{ $experience['description'] }}</p>
                            </article>
                        @endforeach
                    </div>

                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#experienceModal">
                        Add experience
                    </button>
                </section>

                <section class="profile-card mt-4">
                    <h2>Education &amp; skills</h2>
                    <p>{{ $education['degree'] }}, {{ $education['field_of_study'] }} · {{ $education['institution'] }}</p>
                    <p>{{ $education['start_year'] }}–{{ $education['graduation_year'] }}</p>

                    <div class="skill-list" aria-label="Skills">
                        @foreach ($skills as $skill)
                            <span><i></i>{{ $skill }}</span>
                        @endforeach
                    </div>

                    <button class="btn btn-outline-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#educationSkillsModal">
                        Edit education &amp; skills
                    </button>
                </section>

                <footer class="profile-footer">
                    Hirebridge · Private workspace · All times Central unless noted · October 20, 2026
                </footer>
            </div>

            <div class="col-xl-3 col-lg-4">
                <aside class="profile-card profile-side-card">
                    <h2>Resume</h2>
                    <p class="current-resume"><span></span> Current resume</p>
                    <p class="resume-name">{{ $resume['original_filename'] }}</p>
                    <p>{{ $resume['size_label'] }} · Updated {{ $resume['updated_label'] }}</p>

                    <form action="{{ route('candidate.profile.resume.upload') }}" method="POST" enctype="multipart/form-data" data-resume-form>
                        @csrf
                        <input class="visually-hidden" id="resume" type="file" name="resume" accept="application/pdf,.pdf" data-resume-input>
                        <label class="btn btn-outline-primary" for="resume">Replace resume</label>
                    </form>

                    @if ($resume['path'])
                        <a class="resume-download" href="{{ route('candidate.profile.resume.download') }}">Download PDF</a>
                    @else
                        <span class="resume-download disabled" aria-disabled="true">Download PDF</span>
                    @endif
                </aside>

                <aside class="profile-card profile-side-card mt-4">
                    <h2>Visibility &amp; consent</h2>

                    <form action="{{ route('candidate.profile.visibility.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="applied_employers_only" value="0">
                        <label class="form-check profile-check">
                            <input class="form-check-input" type="checkbox" name="applied_employers_only" value="1" @checked(old('applied_employers_only', $visibility['applied_employers_only']))>
                            <span class="form-check-label">Only employers I apply to can view my profile</span>
                        </label>

                        <input type="hidden" name="allow_recruiter_requests" value="0">
                        <label class="form-check profile-check">
                            <input class="form-check-input" type="checkbox" name="allow_recruiter_requests" value="1" @checked(old('allow_recruiter_requests', $visibility['allow_recruiter_requests']))>
                            <span class="form-check-label">Allow agency recruiters to request access</span>
                        </label>

                        <input type="hidden" name="public_search" value="0">
                        <label class="form-check profile-check">
                            <input class="form-check-input" type="checkbox" name="public_search" value="1" @checked(old('public_search', $visibility['public_search']))>
                            <span class="form-check-label">Show my profile in public search</span>
                        </label>

                        <p class="visibility-note">Your contact details are never listed publicly. Submitted application snapshots stay with the relevant hiring team.</p>

                        <button class="btn btn-outline-primary" type="submit">Save visibility</button>
                    </form>
                </aside>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.profile.experience.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="experienceModalLabel">Add experience</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="job_title">Job title</label>
                            <input class="form-control" id="job_title" name="job_title" required maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="company_name">Company</label>
                            <input class="form-control" id="company_name" name="company_name" required maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="place">Location</label>
                            <input class="form-control" id="place" name="place" maxlength="255">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="start_date">Start date</label>
                            <input class="form-control" id="start_date" type="month" name="start_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="end_date">End date</label>
                            <input class="form-control" id="end_date" type="month" name="end_date" data-end-date>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="is_current" value="0">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_current" value="1" data-current-role>
                                <span class="form-check-label">I currently work here</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" maxlength="5000"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add experience</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="educationSkillsModal" tabindex="-1" aria-labelledby="educationSkillsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" action="{{ route('candidate.profile.education-skills.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="educationSkillsModalLabel">Edit education &amp; skills</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="degree">Degree</label>
                            <input class="form-control" id="degree" name="degree" value="{{ $education['degree'] }}" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="field_of_study">Field of study</label>
                            <input class="form-control" id="field_of_study" name="field_of_study" value="{{ $education['field_of_study'] }}" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="institution">Institution</label>
                            <input class="form-control" id="institution" name="institution" value="{{ $education['institution'] }}" required maxlength="255">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="start_year">Start year</label>
                            <input class="form-control" id="start_year" type="number" name="start_year" value="{{ $education['start_year'] }}" min="1950" max="2100" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="graduation_year">Graduation year</label>
                            <input class="form-control" id="graduation_year" type="number" name="graduation_year" value="{{ $education['graduation_year'] }}" min="1950" max="2100" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="skills">Skills</label>
                            <input class="form-control" id="skills" name="skills" value="{{ implode(', ', $skills) }}" maxlength="500" required>
                            <div class="form-text">Separate skills with commas.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="profilePreviewModal" tabindex="-1" aria-labelledby="profilePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="profilePreviewModalLabel">Profile preview</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body profile-preview">
                    <span class="preview-avatar">MC</span>
                    <h3>{{ $profile['name'] }}</h3>
                    <p class="fw-semibold">{{ $profile['headline'] }} · {{ $profile['location'] }}</p>
                    <p>{{ $profile['bio'] }}</p>
                    <a href="{{ $profile['portfolio_url'] }}" target="_blank" rel="noreferrer">{{ $profile['portfolio_url'] }}</a>
                </div>
            </div>
        </div>
    </div>
@endpush
