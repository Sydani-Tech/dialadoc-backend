<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtherCondition extends Model
{
    protected $fillable = [
        'patient_id',
        'name',
        'description',
        // Add other fields specific to other_conditions table
    ];

    /**
     * Get the patient that owns the other condition.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
