<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InterviewerAvailability extends Model
{
    use HasAudit;

    protected $table = 'interviewer_availability';

    protected $fillable = [
        'interviewer_id',
        'start_at',
        'end_at',
        'availability_status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function interviewBooking(): HasOne
    {
        return $this->hasOne(InterviewBooking::class, 'availability_id');
    }
}
