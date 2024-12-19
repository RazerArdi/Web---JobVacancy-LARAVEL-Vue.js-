<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'company', 'location', 
        'salary_min', 'salary_max', 'job_type', 'requirements', 
        'skills', 'application_deadline'
    ];

    protected $casts = [
        'requirements' => 'array',
        'skills' => 'array',
        'application_deadline' => 'date'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}

