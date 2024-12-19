<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['job_listing_id', 'applicant_name', 'email', 'resume'];

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }
}

