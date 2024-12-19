<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'company',
        'location',
        'salary_min',
        'salary_max',
        'job_type',
        'requirements',
        'skills',
        'application_deadline',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requirements' => 'array',
        'skills' => 'array',
        'application_deadline' => 'datetime',
    ];
}
