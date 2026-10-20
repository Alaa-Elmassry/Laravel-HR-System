<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Interview extends Model
{
    use HasAudit;

    protected $table = 'interviews';

    protected $fillable = [
        'application_id',
        'round_no',
        'interview_type',
        'status',
        'meeting_link',
        'location',
        'created_by',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(InterviewBooking::class, 'interview_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(InterviewEvaluation::class, 'interview_id');
    }
}
