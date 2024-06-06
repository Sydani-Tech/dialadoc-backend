<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="HealthMetric",
 *      required={},
 *      @OA\Property(
 *          property="metric_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="measurement_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      )
 * )
 */class HealthMetric extends Model
{
    use HasFactory;    public $table = 'health_metrics';

    public $fillable = [
        'patient_id',
        'metric_type',
        'value',
        'measurement_date',
        'created_by'
    ];

    protected $casts = [
        'metric_type' => 'string',
        'value' => 'string',
        'measurement_date' => 'date'
    ];

    public static array $rules = [
        'patient_id' => 'nullable',
        'metric_type' => 'nullable|string|max:100',
        'value' => 'nullable|string|max:100',
        'measurement_date' => 'nullable',
        'created_by' => 'nullable'
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }
}
