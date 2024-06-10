<?php

namespace App\Models;

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
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="cpd_annual_license",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_details",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */ class Doctor extends Model
{
    use HasFactory;
    public $table = 'doctors';

    public $fillable = [
        'user_id',
        'specialization_id',
        'location_id',
        'experience_years',
        'mdcn_license',
        'cpd_annual_license',
        'bank_details'
    ];

    protected $casts = [
        'mdcn_license' => 'string',
        'cpd_annual_license' => 'string',
        'bank_details' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'specialization_id' => 'nullable',
        'location_id' => 'nullable',
        'experience_years' => 'nullable',
        'mdcn_license' => 'nullable|string|max:100',
        'cpd_annual_license' => 'nullable|string|max:100',
        'bank_details' => 'nullable|string|max:255'
    ];

    public function specialization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Specialization::class, 'specialization_id');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Appointment::class);
    }

    // public function user1s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\User::class, 'appointments');
    // }

    // public function user2s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\User::class, 'consents');
    // }

    // public function patients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Patient::class, 'medical_records');
    // }

    // public function user3s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\User::class, 'prescriptions');
    // }

    // public function user4s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\User::class, 'reviews');
    // }

    // public function patient5s(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    // {
    //     return $this->belongsToMany(\App\Models\Patient::class, 'treatment_plans');
    // }
}
