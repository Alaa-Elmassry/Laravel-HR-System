<?php

use App\Http\Controllers\Candidate\CandidateOfferController;
use App\Http\Controllers\Candidate\CandidatePreferenceController;
use App\Http\Controllers\Candidate\CandidateProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'public.landing')->name('home');

Route::view('/jobs', 'public.jobs.index')
    ->name('jobs.index');

Route::view('/jobs/{id}', 'public.jobs.show')
    ->name('jobs.show');

Route::view('/login', 'auth.login')->name('login');

Route::view('/register', 'auth.register')->name('register');

Route::prefix('candidate/profile')->name('candidate.profile.')->group(function () {
    Route::get('/', [CandidateProfileController::class, 'show'])->name('show');
    Route::put('/', [CandidateProfileController::class, 'update'])->name('update');
    Route::put('/visibility', [CandidateProfileController::class, 'updateVisibility'])->name('visibility.update');
    Route::post('/resume', [CandidateProfileController::class, 'uploadResume'])->name('resume.upload');
    Route::get('/resume', [CandidateProfileController::class, 'downloadResume'])->name('resume.download');
    Route::post('/experience', [CandidateProfileController::class, 'storeExperience'])->name('experience.store');
    Route::put('/education-skills', [CandidateProfileController::class, 'updateEducationSkills'])->name('education-skills.update');
});

Route::prefix('candidate/preferences')->name('candidate.preferences.')->group(function () {
    Route::get('/', [CandidatePreferenceController::class, 'show'])->name('show');
    Route::put('/', [CandidatePreferenceController::class, 'update'])->name('update');
    Route::put('/saved-search', [CandidatePreferenceController::class, 'updateSavedSearch'])->name('saved-search.update');
});

Route::prefix('candidate/applications')->name('candidate.applications.')->group(function () {
    Route::get('/offer', [CandidateOfferController::class, 'show'])->name('offer.show');
    Route::post('/offer/respond', [CandidateOfferController::class, 'respond'])->name('offer.respond');
    Route::post('/offer/question', [CandidateOfferController::class, 'askQuestion'])->name('offer.question');
});
