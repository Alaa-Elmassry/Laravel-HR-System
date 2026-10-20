<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CandidateCv extends Model
{
    use HasAudit;

    protected $table = 'candidate_cvs';

    protected $fillable = [
        'candidate_id',
        'version',
        'storage_path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'is_active',
        'uploaded_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class, 'candidate_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'cv_id');
    }

    public function cvMatchResults(): HasMany
    {
        return $this->hasMany(CvMatchResult::class, 'cv_id');
    }
}
