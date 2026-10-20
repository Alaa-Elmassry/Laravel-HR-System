<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exam extends Model
{
    use HasAudit;

    protected $table = 'exams';

    protected $fillable = [
        'company_id',
        'created_by',
        'title',
        'time_limit_min',
        'attempt_limit',
        'passing_score',
        'status',
    ];

    protected $casts = [
        'passing_score' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jobExams(): HasMany
    {
        return $this->hasMany(JobExam::class, 'exam_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }
}
