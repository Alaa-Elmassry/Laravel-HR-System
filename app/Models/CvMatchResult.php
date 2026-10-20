<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CvMatchResult extends Model
{
    use HasAudit;

    protected $table = 'cv_match_results';

    protected $fillable = [
        'application_id',
        'cv_id',
        'score',
        'matched_skills',
        'missing_skills',
        'summary',
        'model_version',
        'request_id',
        'run_status',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'matched_skills' => 'array',
        'missing_skills' => 'array',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CandidateCv::class, 'cv_id');
    }

    public function aiReviewDecisions(): HasMany
    {
        return $this->hasMany(AiReviewDecision::class, 'match_result_id');
    }
}
