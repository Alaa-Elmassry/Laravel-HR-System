<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InterviewEvaluation extends Model
{
    use HasAudit;

    protected $table = 'interview_evaluations';

    protected $fillable = [
        'interview_id',
        'evaluator_id',
        'numeric_score',
        'internal_notes',
        'candidate_feedback',
        'feedback_shared_at',
    ];

    protected $casts = [
        'numeric_score' => 'decimal:2',
        'feedback_shared_at' => 'datetime',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
