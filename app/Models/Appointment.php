<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Appointment",
 *      required={"status"},
 *      @OA\Property(
 *          property="doctor_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="patient_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="affected_body_part",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="nature_of_illness",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type_of_appointment",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="appointment_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Appointment extends Model
{
    use HasFactory;
    public $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    public $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'affected_body_part',
        'nature_of_illness',
        'type_of_appointment',
        'description_of_illness',
        'created_by',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'datetime'
    ];

    public static array $rules = [
        'doctor_id' => 'nullable',
        'patient_id' => 'nullable',
        'appointment_date' => 'nullable',
        'created_by' => 'nullable',
        'status' => 'required'
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'patient_id');
    }

    public function consultations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Consultation::class, 'appointment_id');
    }
}
