<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Insurance",
 *      required={},
 *      @OA\Property(
 *          property="provider_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="policy_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="coverage_details",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Insurance extends Model
{
    use HasFactory;    public $table = 'insurances';

    public $fillable = [
        'patient_id',
        'provider_name',
        'policy_number',
        'coverage_details'
    ];

    protected $casts = [
        'provider_name' => 'string',
        'policy_number' => 'string',
        'coverage_details' => 'string'
    ];

    public static array $rules = [
        'patient_id' => 'nullable',
        'provider_name' => 'nullable|string|max:100',
        'policy_number' => 'nullable|string|max:50',
        'coverage_details' => 'nullable|string|max:65535'
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }
}
