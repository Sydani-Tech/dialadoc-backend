<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Facility;
use App\Models\Consultation;
use App\Models\PatientRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Patient",
 *      required={},
 *      @OA\Property(
 *          property="date_of_birth",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="blood_group",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="genotype",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="country",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="state",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="lga",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="phone_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="weight",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="height",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="surgical_history",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="bool",
 *      ),
 *     @OA\Property(
 *          property="allergies_1",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="allergies_2",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="condition_1",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="condition_2",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="average_heart_rate",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *     @OA\Property(
 *          property="other_allergies",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *     @OA\Property(
 *          property="other_condition",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 * )
 */
class Patient extends Model
{
    use HasFactory;

    public $table = 'patients';

    protected $primaryKey = 'patient_id';

    public $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'blood_group',
        'genotype',
        'location_id',
        'image',
        'country',
        'state',
        'lga',
        'phone_number',
        'weight',
        'height',
        'surgical_history',
        'average_heart_rate',
        'allergies_1',
        'allergies_2',
        'other_allergies',
        'condition_1',
        'condition_2',
        'other_conditions',
        'doctor_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gender' => 'integer',
        'weight' => 'decimal:2',
        'height' => 'decimal:2'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|integer',
        'blood_group' => 'nullable|string|max:10',
        'genotype' => 'nullable|string|max:10',
        'location_id' => 'nullable|integer',
        'image' => 'nullable|string',
        'country' => 'nullable|string',
        'state' => 'nullable|string',
        'lga' => 'nullable|string',
        'phone_number' => 'nullable|string',
        'weight' => 'nullable|numeric',
        'height' => 'nullable|numeric',
        'surgical_history' => 'nullable|bool',
        'average_heart_rate' => 'nullable|integer',
        'allergies_1' => 'nullable|string',
        'allergies_2' => 'nullable|string',
        'other_allergies' => 'nullable|string',
        'condition_1' => 'nullable|string',
        'condition_2' => 'nullable|string',
        'other_condition' => 'nullable|string',
        'doctor_id' => 'nullable|integer',
    ];

    public function conditions(): HasMany
    {
        return $this->hasMany(Condition::class);
    }

    /**
     * Get the other conditions for the patient.
     */
    public function otherConditions(): HasMany
    {
        return $this->hasMany(OtherCondition::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function healthMetrics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\HealthMetric::class, 'patient_id');
    }

    public function insurances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Insurance::class, 'patient_id');
    }

    public function patient_records()
    {
        return $this->hasMany(PatientRecord::class, 'patient_id', 'patient_id');
    }

    public function consultations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Consultation::class, 'patient_id', 'patient_id');
    }

    // public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     // these foreign local key should change accordingly
    //     return $this->hasMany(\App\Models\Appointment::class, 'consultation_id');
    // }

    // public function facility()
    // {
    //     // these foreign local key should change accordingly
    //     return $this->hasOne(Facility::class, 'facility_id', 'doctor_id');
    // }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'doctor_id', 'doctor_id');
    }

    // public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Doctor::class, 'medical_records');
    // }

    // public function doctor1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Doctor::class, 'treatment_plans');
    // }

    /**
     * Get the other allergies for the patient.
     */
    public function otherAllergies(): HasMany
    {
        return $this->hasMany(OtherAllergy::class);
    }

    public function allergies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Allergy::class, 'patient_id');
    }

    public function vitalSigns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\VitalSign::class, 'patient_id');
    }

    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Consultation::class);
    }

    public function facilityAppointments()
    {
        return $this->hasManyThrough(FacilityAppointment::class, PatientRecord::class);
    }
}
