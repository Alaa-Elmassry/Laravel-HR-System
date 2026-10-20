<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserNotification extends Model
{
    use HasAudit;

    protected $table = 'notifications';

    protected $fillable = [
        'recipient_id',
        'channel',
        'type',
        'title',
        'body',
        'related_type',
        'related_id',
        'delivery_status',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
