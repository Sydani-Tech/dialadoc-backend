<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Appointment",
 *      required={"consultation_id", "appointment_date", "appointment_time"},
 *      @OA\Property(
 *          property="consultation_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="appointment_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="date",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="appointment_time",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="date",
 *          format="date"
 *      ),
 * )
 */
class Appointment extends Model
{
    use HasFactory;
    public $table = 'appointments';
    protected $primaryKey = 'appointment_id';

    public $fillable = [
        'consultation_id',
        'appointment_date',
        'appointment_time',
        'created_by',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'datetime'
    ];

    public static array $rules = [
        'consultation_id' => 'required|integer|exists:consultations,consultation_id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
    ];

    public function consultation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Consultation::class, 'consultation_id');
    }
}
