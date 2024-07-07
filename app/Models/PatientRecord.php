<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="PatientRecord",
 *      required={"patient_id","update_type","suspected_illness","findings","recommended_tests","appointment_id", "prescriptions"},
 *      @OA\Property(
 *          property="update_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="suspected_illness",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="findings",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="recommended_tests",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="recommended_facility",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="appointment_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="prescriptions",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class PatientRecord extends Model
{
    use HasFactory;
    public $table = 'patient_records';

    public $fillable = [
        'patient_id',
        'update_type',
        'suspected_illness',
        'findings',
        'recommended_tests',
        'recommended_facility',
        'appointment_id',
        'prescriptions'
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'update_type' => 'string',
        'suspected_illness' => 'string',
        'findings' => 'string',
        'recommended_tests' => 'string',
        'recommended_facility' => 'integer',
        'appointment_id' => 'integer',
        'prescriptions' => 'string',
    ];

    public static array $rules = [
        'patient_id' => 'required|integer',
        'update_type' => 'required',
        'suspected_illness' => 'required',
        'findings' => 'required',
        'recommended_tests' => 'required',
        'recommended_facility' => 'required|integer|exists:facilities,id',
        'appointment_id' => 'required|integer|exists:appointments,appointment_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Appointment::class, 'appointment_id', 'appointment_id');
    }

    public function facility(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Facility::class, 'recommended_facility');
    }
}
