<?php

namespace App\Models;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Doctor",
 *      required={},
 *      @OA\Property(
 *          property="mdcn_license",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="binary",
 *      ),
 *      @OA\Property(
 *          property="cpd_annual_license",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="binary",
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
 *      ),
 *      @OA\Property(
 *          property="bank_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_account_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
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
 *          property="bio",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="healthcare_practitioner_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="role_in_facility",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="years_practising",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      )
 * )
 */
class Doctor extends Model
{
    use HasFactory;
    public $table = 'doctors';
    protected $primaryKey = 'doctor_id';

    public $fillable = [
        'user_id',
        'specialization_id',
        'experience_years',
        'mdcn_license',
        'cpd_annual_license',
        'bank_name',
        'bank_account_number',
        'country',
        'state',
        'lga',
        'bio',
        'healthcare_practitioner_type',
        'role_in_facility',
        'years_practising',
        'experience_years'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'specialization_id' => 'integer',
        'experience_years' => 'string',
        'mdcn_license' => 'string',
        'cpd_annual_license' => 'string',
        'bank_name' => 'string',
        'bank_account_number' => 'string',
        'country' => 'string',
        'state' => 'string',
        'lga' => 'string',
        'bio' => 'string',
        'healthcare_practitioner_type' => 'string',
        'role_in_facility' => 'string',
        'years_practising' => 'integer',
        'experience_years' => 'integer'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'specialization_id' => 'nullable',
        'experience_years' => 'nullable',
        'mdcn_license' => 'nullable|mimetypes:pdf|max:1000',
        'cpd_annual_license' => 'nullable|mimetypes:pdf|max:1000',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'bank_name' => 'nullable|string|max:255',
        'bank_account_number' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'lga' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:65535',
        'healthcare_practitioner_type' => 'nullable|string|max:255',
        'role_in_facility' => 'nullable|string|max:255',
        'years_practising' => 'nullable|integer|min:0',
        'experience_years' => 'nullable|integer|min:0'
    ];

    public function specialization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Specialization::class, 'specialization_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // public function appointments()
    // {
    //     return $this->hasManyThrough(Appointment::class, Consultation::class);
    // }

    // public function consultations(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(Consultation::class, 'doctor_id', 'doctor_id');
    // }

    public function user1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'consents');
    }

    public function medicalRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\MedicalRecord::class, 'doctor_id');
    }

    public function prescriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Prescription::class, 'doctor_id');
    }

    public function patients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Patient::class, 'reviews');
    }
}
