<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Index: Get all applications for a specific job
    public function index($job_id)
    {
        $job = JobListing::findOrFail($job_id);
        return response()->json($job->applications);
    }

    // Store: Create a new application for a specific job
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

    // Show: Get a specific application by ID
    public function show($job_id, $application_id)
    {
        $job = JobListing::findOrFail($job_id);
        $application = $job->applications()->findOrFail($application_id);

        return response()->json($application);
    }

    // Update: Update an existing application
    public function update(Request $request, $job_id, $application_id)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string',
            'email' => 'required|email',
            'resume' => 'required|string',
        ]);

        $job = JobListing::findOrFail($job_id);
        $application = $job->applications()->findOrFail($application_id);
        $application->update($validated);

        return response()->json($application);
    }

    // Destroy: Delete an application
    public function destroy($job_id, $application_id)
    {
        $job = JobListing::findOrFail($job_id);
        $application = $job->applications()->findOrFail($application_id);
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully'], 204);
    }
}
