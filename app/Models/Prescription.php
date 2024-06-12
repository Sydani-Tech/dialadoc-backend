<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Prescription",
 *      required={},
 *      @OA\Property(
 *          property="date_issued",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      )
 * )
 */ class Prescription extends Model
{
    use HasFactory;
    public $table = 'prescriptions';

    protected $primaryKey = 'prescription_id';

    public $fillable = [
        'doctor_id',
        'patient_id',
        'date_issued',
        'created_by'
    ];

    protected $casts = [
        'date_issued' => 'date'
    ];

    public static array $rules = [
        'doctor_id' => 'nullable',
        'patient_id' => 'nullable',
        'date_issued' => 'nullable',
        'created_by' => 'nullable'
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'patient_id');
    }

    public function pharmacies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Pharmacy::class, 'orders');
    }

    public function medications(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Medication::class, 'prescription_medications');
    }
}
