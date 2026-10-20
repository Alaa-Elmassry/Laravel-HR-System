<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExamAttempt extends Model
{
    use HasAudit;

    protected $table = 'exam_attempts';

    protected $fillable = [
        'exam_id',
        'application_id',
        'attempt_no',
        'status',
        'camera_consent_at',
        'started_at',
        'submitted_at',
    ];

    protected $casts = [
        'camera_consent_at' => 'datetime',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'attempt_id');
    }

    public function gradingResults(): HasMany
    {
        return $this->hasMany(GradingResult::class, 'attempt_id');
    }

    public function proctoringEvents(): HasMany
    {
        return $this->hasMany(ProctoringEvent::class, 'attempt_id');
    }
}
