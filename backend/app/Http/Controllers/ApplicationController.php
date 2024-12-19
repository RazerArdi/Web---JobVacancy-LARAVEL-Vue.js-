<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request, $job_id)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string',
            'email' => 'required|email',
            'resume' => 'required|string',
        ]);

        $job = JobListing::findOrFail($job_id);
        $application = $job->applications()->create($validated);

        return response()->json($application, 201);
    }
}

