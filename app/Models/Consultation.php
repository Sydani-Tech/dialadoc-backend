<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Consultation",
 *      required={"created_at"},
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="date",
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="date",
 *      ),
 *      @OA\Property(
 *          property="patient_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="doctor_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="affected_body_part",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="nature_of_illness",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="type_of_appointment",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 * )
 */ class Consultation extends Model
{
    use HasFactory;
    public $table = 'consultations';
    protected $primaryKey = 'consultation_id';

    public $fillable = [
        'patient_id',
        'doctor_id',
        'affected_body_part',
        'nature_of_illness',
        'type_of_appointment',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [

    ];

    public static array $rules = [
        'patient_id' => 'required|exists:patients,patient_id',
        'doctor_id' => 'required|exists:doctors,doctor_id',
        'affected_body_part' => 'required|string',
        'nature_of_illness' => 'required|string',
        'type_of_appointment' => 'required|string',
        'description' => 'required|string',
    ];
}
