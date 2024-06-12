<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Condition extends Model

{
    protected $fillable = [
        'patient_id',
        'condition_name',
    ];

    protected $primaryKey = 'condition_id';

    /**
     * Get the patient that owns the condition.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
