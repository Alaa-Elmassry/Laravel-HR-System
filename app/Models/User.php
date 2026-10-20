<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Authenticatable
{
    use HasApiTokens, HasAudit;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'account_status',
        'locale',
        'theme',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function candidateProfile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class, 'user_id');
    }

  
    public function membership(): HasOne
    {
        return $this->hasOne(CompanyEmployee::class, 'user_id');
    }

    public function ownedCompanies(): HasMany
    {
        return $this->hasMany(Company::class, 'owner_user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->withPivot('company_id','assigned_at')->withTimestamps();
    }

    public function calendarIntegrations(): HasMany
    {
        return $this->hasMany(CalendarIntegration::class, 'user_id');
    }

    public function chatbotSessions(): HasMany
    {
        return $this->hasMany(ChatbotSession::class, 'user_id');
    }

    public function receivedNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'recipient_id');
    }

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(InterviewerAvailability::class, 'interviewer_id');
    }

    public function isCompanyApproved(int $companyId): bool
    {
        return $this->membership?->company_id === $companyId && $this->membership?->status === 'approved';
    }
    public function country(): BelongsTo
{
    return $this->belongsTo(Country::class);
}
}
