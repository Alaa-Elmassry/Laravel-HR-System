<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job extends Model
{
    use HasAudit;

    protected $table = 'jobs';

    protected $fillable = [
        'company_id',
        'category_id',
        'created_by',
        'title',
        'description',
        'location',
        'work_mode',
        'employment_type',
        'salary_min',
        'salary_max',
        'currency',
        'salary_period',
        'experience_years',
        'department',
        'openings_count',
        'deadline',
        'visibility',
        'private_apply_mode',
        'status',
        'published_at',
        'closed_at',
    ];

    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'deadline' => 'datetime',
        'published_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function nominations(): HasMany
    {
        return $this->hasMany(JobNomination::class, 'job_id');
    }

    public function interviewRounds(): HasMany
    {
        return $this->hasMany(JobInterviewRound::class, 'job_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id');
    }

    public function jobExams(): HasMany
    {
        return $this->hasMany(JobExam::class, 'job_id');
    }

    public function salaryRecommendations(): HasMany
    {
        return $this->hasMany(SalaryRecommendation::class, 'job_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'job_id', 'skill_id')->withPivot('is_required')->withTimestamps();
    }
}
