<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="PrescriptionMedication",
 *      required={},
 *      @OA\Property(
 *          property="dosage",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="frequency",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class PrescriptionMedication extends Model
{
    use HasFactory;    public $table = 'prescription_medications';

    public $fillable = [
        'prescription_id',
        'medication_id',
        'dosage',
        'frequency'
    ];

    protected $casts = [
        'dosage' => 'string',
        'frequency' => 'string'
    ];

    public static array $rules = [
        'prescription_id' => 'nullable',
        'medication_id' => 'nullable',
        'dosage' => 'nullable|string|max:100',
        'frequency' => 'nullable|string|max:100'
    ];

    public function medication(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Medication::class, 'medication_id');
    }

    public function prescription(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Prescription::class, 'prescription_id');
    }
}
