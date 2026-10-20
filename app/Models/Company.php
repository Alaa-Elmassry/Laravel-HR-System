<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasAudit;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'website',
        'industry',
        'doc_path',
        'logo_path',
        'contact_email',
        'contact_phone',
        'address',
        'status',
        'owner_user_id',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class, 'company_id');
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(CompanySocialLink::class, 'company_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'company_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'company_id');
    }

    public function salaryRecords(): HasMany
    {
        return $this->hasMany(SalaryRecord::class, 'company_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'company_id');
    }

    public function activeEmployees(): HasMany
    {
        return $this->hasMany(CompanyEmployee::class, 'company_id')->where('status', 'approved');
    }
}
