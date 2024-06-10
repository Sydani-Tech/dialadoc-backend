<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
 *      )
 * )
 */ class Patient extends Model
{
    use HasFactory;
    public $table = 'patients';

    public $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'blood_group',
        'genotype',
        'location_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'blood_group' => 'string',
        'genotype' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'date_of_birth' => 'nullable',
        'gender' => 'nullable',
        'blood_group' => 'nullable|string|max:10',
        'genotype' => 'nullable|string|max:10',
        'location_id' => 'nullable'
    ];

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

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Appointment::class);
    }

    // public function doctors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Doctor::class, 'medical_records');
    // }

    // public function doctor1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Doctor::class, 'treatment_plans');
    // }

    public function allergies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Allergy::class, 'patient_id');
    }

    public function vitalSigns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\VitalSign::class, 'patient_id');
    }
}
