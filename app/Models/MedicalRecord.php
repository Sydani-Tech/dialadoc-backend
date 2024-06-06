<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="MedicalRecord",
 *      required={"date_created"},
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="date_created",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class MedicalRecord extends Model
{
    use HasFactory;    public $table = 'medical_records';

    public $fillable = [
        'patient_id',
        'doctor_id',
        'created_by',
        'record_type',
        'description',
        'date_created'
    ];

    protected $casts = [
        'description' => 'string',
        'date_created' => 'datetime'
    ];

    public static array $rules = [
        'patient_id' => 'nullable',
        'doctor_id' => 'nullable',
        'created_by' => 'nullable',
        'record_type' => 'nullable',
        'description' => 'nullable|string|max:65535',
        'date_created' => 'required'
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }

    public function testResults(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\TestResult::class, 'record_id');
    }
}
