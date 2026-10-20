<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyEmployee extends Model
{
    use HasAudit;

    protected $table = 'company_employees';

    protected $fillable = [
        'company_id',
        'user_id',
        'requested_job_title',
        'requested_department',
        'status',
        'role_id',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'requested_at',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'requested_at' => 'datetime',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function jobNominations(): HasMany
    {
        return $this->hasMany(JobNomination::class, 'employee_id');
    }
}
