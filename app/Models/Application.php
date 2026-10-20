<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasAudit;

    protected $table = 'applications';

    protected $fillable = [
        'job_id',
        'candidate_id',
        'cv_id',
        'cover_note',
        'consent_at',
        'status',
        'attempt_no',
        'applied_at',
        'withdrawn_at',
    ];

    protected $casts = [
        'consent_at' => 'datetime',
        'applied_at' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CandidateCv::class, 'cv_id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class, 'application_id');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'application_id');
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class, 'application_id');
    }

    public function examAttempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class, 'application_id');
    }

    public function cvMatchResults(): HasMany
    {
        return $this->hasMany(CvMatchResult::class, 'application_id');
    }
}
