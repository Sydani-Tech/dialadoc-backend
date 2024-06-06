<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="ConsentType",
 *      required={"consent_date"},
 *      @OA\Property(
 *          property="granted",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="consent_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class ConsentType extends Model
{
    use HasFactory;    public $table = 'consents';

    public $fillable = [
        'user_id',
        'doctor_id',
        'consent_type',
        'granted',
        'consent_date'
    ];

    protected $casts = [
        'granted' => 'boolean',
        'consent_date' => 'datetime'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'doctor_id' => 'nullable',
        'consent_type' => 'nullable',
        'granted' => 'nullable|boolean',
        'consent_date' => 'required'
    ];

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
