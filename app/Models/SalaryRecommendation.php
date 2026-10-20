<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SalaryRecommendation extends Model
{
    use HasAudit;

    protected $table = 'salary_recommendations';

    protected $fillable = [
        'job_id',
        'salary_record_id',
        'range_min',
        'range_max',
        'currency',
    ];

    protected $casts = [
        'range_min' => 'decimal:2',
        'range_max' => 'decimal:2',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function salaryRecord(): BelongsTo
    {
        return $this->belongsTo(SalaryRecord::class, 'salary_record_id');
    }
}
