<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="FacilityAppointment",
 *      required={"patient_record_id","appointment_date","appointment_time","facility_id","appointment_status","results"},
 *      @OA\Property(
 *          property="patient_record_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="facility_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="appointment_status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="results",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="documents_url",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
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
 */ class FacilityAppointment extends Model
{
    use HasFactory;
    public $table = 'facility_appointments';

    public $fillable = [
        'patient_record_id',
        'appointment_date',
        'appointment_time',
        'facility_id',
        'appointment_status',
        'results',
        'documents_url'
    ];

    protected $casts = [
        'patient_record_id' => 'integer',
        'facility_id' => 'integer',
        'appointment_status' => 'integer',
        'results' => 'string',
        'documents_url' => 'string'
    ];

    public static array $rules = [
        'patient_record_id' => 'required',
        'appointment_date' => 'required',
        'appointment_time' => 'required',
        'facility_id' => 'required',
        'appointment_status' => 'required',
        'results' => 'required'
    ];

    public function patientRecord(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PatientRecord::class, 'patient_record_id');
    }

    public function facility(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Facility::class, 'id');
    }
}
