<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtherAllergy extends Model
{
    protected $fillable = [
        'name',
        'value',
        'patient_id',
        // Add other fields specific to other_allergies table
    ];

    /**
     * Get the patient that owns the other allergy.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
