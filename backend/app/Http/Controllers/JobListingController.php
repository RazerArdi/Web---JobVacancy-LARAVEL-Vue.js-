<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Application;

class JobListingController extends Controller
{
    // Index: Get all job listings
    public function index()
    {
        return response()->json(JobListing::all());
    }

    // Store: Create a new job listing
    public function store(Request $request)
    {
        try {
            Log::info('Creating job listing with data:', $request->all()); // Log incoming data

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'company' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'salary_min' => 'required|integer',
                'salary_max' => 'required|integer',
                'job_type' => 'required|string',
                'requirements' => 'required|array',
                'skills' => 'required|array',
                'application_deadline' => 'required|date'
            ]);

            $job = JobListing::create($validated);

            Log::info('Job created successfully:', $job->toArray()); // Log successful job creation

            return response()->json($job, 201);
        } catch (\Exception $e) {
            Log::error('Error creating job listing:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create job'], 500);
        }
    }

    // Show: Get a specific job listing by ID
    public function show($id)
    {
        $job = JobListing::find($id);

        // If job not found, return 404 error
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // Return the job data
        return response()->json($job);
    }

    // Update: Update an existing job listing
    public function update(Request $request, $id)
    {
        try {
            // Validate incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'company' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'salary_min' => 'required|integer',
                'salary_max' => 'required|integer',
                'job_type' => 'required|string',
                'requirements' => 'required|array',
                'skills' => 'required|array',
                'application_deadline' => 'required|date'
            ]);

            // Find the job listing by ID
            $job = JobListing::find($id);

            // If job not found, return 404 error
            if (!$job) {
                return response()->json(['message' => 'Job not found'], 404);
            }

            // Update the job listing with validated data
            $job->update($validated);

            // Return the updated job data
            return response()->json($job);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, return errors
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Destroy: Delete a job listing by ID
    public function destroy($id)
    {
        $job = JobListing::find($id);

        // If job not found, return 404 error
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // Delete the job listing
        $job->delete();

        // Return success message
        return response()->json(['message' => 'Job deleted successfully'], 204);
    }
}

