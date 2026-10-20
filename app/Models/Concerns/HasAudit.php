<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fills uid (creator) and luid (last updater) automatically from the logged-in user.
 * Used by every model. Works through Eloquent events only
 * (not Model::query()->update() or DB::table()).
 */
trait HasAudit
{
    protected static function bootHasAudit(): void
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->uid ??= auth()->id();
                $model->luid = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->luid = auth()->id();
            }
        });
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'luid');
    }
}
