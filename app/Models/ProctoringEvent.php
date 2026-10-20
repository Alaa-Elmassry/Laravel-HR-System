<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProctoringEvent extends Model
{
    use HasAudit;

    protected $table = 'proctoring_events';

    protected $fillable = [
        'attempt_id',
        'event_type',
        'confidence',
        'model_version',
        'occurred_at',
        'evidence_key',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
        'occurred_at' => 'datetime',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProctoringReview::class, 'event_id');
    }
}
