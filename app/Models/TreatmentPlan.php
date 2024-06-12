<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="TreatmentPlan",
 *      required={},
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="start_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="end_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      )
 * )
 */ class TreatmentPlan extends Model
{
    use HasFactory;
    public $table = 'treatment_plans';
    protected $primaryKey = 'plan_id';

    public $fillable = [
        'patient_id',
        'doctor_id',
        'description',
        'start_date',
        'end_date',
        'created_by'
    ];

    protected $casts = [
        'description' => 'string',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public static array $rules = [
        'patient_id' => 'nullable',
        'doctor_id' => 'nullable',
        'description' => 'nullable|string|max:65535',
        'start_date' => 'nullable',
        'end_date' => 'nullable',
        'created_by' => 'nullable'
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }

    public function progressReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\ProgressReport::class, 'plan_id');
    }
}
