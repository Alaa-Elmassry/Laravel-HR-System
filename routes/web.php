<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/', 'public.landing')->name('home');

Route::view('/jobs', 'public.jobs.index')
    ->name('jobs.index');

Route::view('/jobs/{id}', 'public.jobs.show')
    ->name('jobs.show');
