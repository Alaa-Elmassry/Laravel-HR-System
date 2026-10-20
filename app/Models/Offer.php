<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Offer extends Model
{
    use HasAudit;

    protected $table = 'offers';

    protected $fillable = [
        'application_id',
        'salary_amount',
        'currency',
        'salary_period',
        'start_date',
        'status',
        'sent_by',
        'sent_at',
        'responded_at',
        'expires_at',
    ];

    protected $casts = [
        'salary_amount' => 'decimal:2',
        'start_date' => 'date',
        'sent_at' => 'datetime',
        'responded_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
