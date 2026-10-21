<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateExperienceRequest;
use App\Http\Requests\Candidate\UpdateCandidateEducationSkillsRequest;
use App\Http\Requests\Candidate\UpdateCandidateProfileRequest;
use App\Http\Requests\Candidate\UpdateCandidateVisibilityRequest;
use App\Http\Requests\Candidate\UploadCandidateResumeRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateProfileController extends Controller
{
    public function show(): View
    {
        $defaults = $this->defaults();

        return view('candidate.profile.index', [
            'profile' => session('candidate-profile.profile', $defaults['profile']),
            'resume' => session('candidate-profile.resume', $defaults['resume']),
            'visibility' => session('candidate-profile.visibility', $defaults['visibility']),
            'experiences' => session('candidate-profile.experiences', $defaults['experiences']),
            'education' => session('candidate-profile.education', $defaults['education']),
            'skills' => session('candidate-profile.skills', $defaults['skills']),
        ]);
    }

    public function update(UpdateCandidateProfileRequest $request): RedirectResponse
    {
        $profile = array_merge(
            $this->defaults()['profile'],
            session('candidate-profile.profile', []),
            $request->validated(),
        );

        session()->put('candidate-profile.profile', $profile);

        return to_route('candidate.profile.show')->with('status', 'Profile details saved successfully.');
    }

    public function updateVisibility(UpdateCandidateVisibilityRequest $request): RedirectResponse
    {
        session()->put('candidate-profile.visibility', $request->validated());

        return to_route('candidate.profile.show')->with('status', 'Visibility preferences saved successfully.');
    }

    public function uploadResume(UploadCandidateResumeRequest $request): RedirectResponse
    {
        $resume = $request->file('resume');
        $path = $resume->store('candidate-resumes');

        session()->put('candidate-profile.resume', [
            'path' => $path,
            'original_filename' => $resume->getClientOriginalName(),
            'size_label' => number_format($resume->getSize() / 1024).' KB',
            'updated_label' => now()->format('M j, Y'),
        ]);

        return to_route('candidate.profile.show')->with('status', 'Resume replaced successfully.');
    }

    public function downloadResume(): StreamedResponse
    {
        $resume = session('candidate-profile.resume');

        abort_unless($resume && Storage::exists($resume['path']), 404);

        return Storage::download($resume['path'], $resume['original_filename']);
    }

    public function storeExperience(StoreCandidateExperienceRequest $request): RedirectResponse
    {
        $experience = $request->validated();
        $experience['end_date'] = $experience['is_current'] ? null : $experience['end_date'];
        $experience['start_label'] = Carbon::createFromFormat('Y-m', $experience['start_date'])->format('F Y');
        $experience['end_label'] = $experience['is_current']
            ? 'Present'
            : Carbon::createFromFormat('Y-m', $experience['end_date'])->format('F Y');

        $experiences = session('candidate-profile.experiences', $this->defaults()['experiences']);
        $experiences[] = $experience;
        session()->put('candidate-profile.experiences', $experiences);

        return to_route('candidate.profile.show')->with('status', 'Experience added successfully.');
    }

    public function updateEducationSkills(UpdateCandidateEducationSkillsRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $skills = collect(explode(',', $validated['skills']))
            ->map(fn (string $skill): string => trim($skill))
            ->filter()
            ->unique()
            ->values()
            ->all();

        session()->put('candidate-profile.education', [
            'degree' => $validated['degree'],
            'field_of_study' => $validated['field_of_study'],
            'institution' => $validated['institution'],
            'start_year' => $validated['start_year'],
            'graduation_year' => $validated['graduation_year'],
        ]);
        session()->put('candidate-profile.skills', $skills);

        return to_route('candidate.profile.show')->with('status', 'Education and skills saved successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function defaults(): array
    {
        return [
            'profile' => [
                'name' => 'Maya Chen',
                'headline' => 'Senior Product Designer',
                'location' => 'Austin, Texas',
                'bio' => 'Product designer with 8 years of experience turning complex SaaS workflows into clear, accessible experiences. I lead discovery, interaction design, and systems work in close partnership with product and engineering.',
                'portfolio_url' => 'https://mayachen.design',
            ],
            'resume' => [
                'path' => null,
                'original_filename' => 'Maya_Chen_Resume.pdf',
                'size_label' => '248 KB',
                'updated_label' => 'Oct 10, 2026',
            ],
            'visibility' => [
                'applied_employers_only' => true,
                'allow_recruiter_requests' => true,
                'public_search' => false,
            ],
            'experiences' => [
                [
                    'job_title' => 'Senior Product Designer',
                    'company_name' => 'Fieldwork',
                    'place' => 'Austin, TX',
                    'start_date' => '2022-03',
                    'end_date' => null,
                    'is_current' => true,
                    'start_label' => 'March 2022',
                    'end_label' => 'Present',
                    'description' => 'Led design for an operations platform, from customer discovery to delivery. Built reusable workflow patterns and partnered with engineering to improve accessibility.',
                ],
                [
                    'job_title' => 'Product Designer',
                    'company_name' => 'Parcel Systems',
                    'place' => 'Austin, TX',
                    'start_date' => '2018-06',
                    'end_date' => '2022-02',
                    'is_current' => false,
                    'start_label' => 'June 2018',
                    'end_label' => 'February 2022',
                    'description' => 'Designed enterprise planning and reporting tools. Facilitated user testing and contributed to the company’s first shared design system.',
                ],
            ],
            'education' => [
                'degree' => 'BFA',
                'field_of_study' => 'Communication Design',
                'institution' => 'Texas State University',
                'start_year' => 2014,
                'graduation_year' => 2018,
            ],
            'skills' => ['Figma', 'Design systems', 'User research', 'Prototyping'],
        ];
    }
}
