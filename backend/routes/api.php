<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;

// Job Listings Routes (API Resource Controller)
Route::apiResource('job-listings', JobListingController::class);

// Application Routes for a specific job (Custom routes for applications)
Route::prefix('job-listings/{job_id}')->group(function () {
    // Apply for a job (Create an application for a specific job)
    Route::post('apply', [ApplicationController::class, 'store']); // Store application
    
    // Get all applications for a job
    Route::get('applications', [ApplicationController::class, 'index']); // Get all applications for a job
    
    // Show a specific application for a job
    Route::get('applications/{application_id}', [ApplicationController::class, 'show']); // Show application
    
    // Update an application for a job
    Route::put('applications/{application_id}', [ApplicationController::class, 'update']); // Update application
    
    // Delete an application for a job
    Route::delete('applications/{application_id}', [ApplicationController::class, 'destroy']); // Delete application
});


