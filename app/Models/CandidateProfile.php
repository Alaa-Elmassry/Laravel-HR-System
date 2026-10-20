<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CandidateProfile extends Model
{
    use HasAudit;

    protected $table = 'candidate_profiles';

    protected $fillable = [
        'user_id',
        'phone',
        'location',
        'headline',
        'bio',
        'photo_path',
        'has_no_experience',
        'years_experience',
    ];

    protected $casts = [
        'has_no_experience' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function experience(): HasMany
    {
        return $this->hasMany(CandidateExperience::class, 'candidate_id');
    }

    public function cvs(): HasMany
    {
        return $this->hasMany(CandidateCv::class, 'candidate_id');
    }

    public function education(): HasMany
    {
        return $this->hasMany(CandidateEducation::class, 'candidate_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(CandidateCourse::class, 'candidate_id');
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(CandidateSocialLink::class, 'candidate_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills', 'candidate_id', 'skill_id')->withPivot('level')->withTimestamps();
    }
}
