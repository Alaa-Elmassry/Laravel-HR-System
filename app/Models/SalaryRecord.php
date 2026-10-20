<?php

namespace App\Models;

use App\Models\Concerns\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SalaryRecord extends Model
{
    use HasAudit;

    protected $table = 'salary_records';

    protected $fillable = [
        'company_id',
        'category_id',
        'job_title',
        'location',
        'currency',
        'amount_min',
        'amount_max',
        'experience_level',
        'source',
        'recorded_at',
    ];

    protected $casts = [
        'amount_min' => 'decimal:2',
        'amount_max' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(SalaryRecommendation::class, 'salary_record_id');
    }
}
