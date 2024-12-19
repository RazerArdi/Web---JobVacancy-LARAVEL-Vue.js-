<?php

// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;

Route::apiResource('job-listings', JobListingController::class);
Route::post('job-listings/{job_id}/apply', [ApplicationController::class, 'store']);

