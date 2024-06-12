<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Consultation",
 *      required={"consultation_date"},
 *      @OA\Property(
 *          property="notes",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="consultation_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Consultation extends Model
{
    use HasFactory;
    public $table = 'consultations';
    protected $primaryKey = 'consultation_id';

    public $fillable = [
        'appointment_id',
        'notes',
        'created_by',
        'consultation_date'
    ];

    protected $casts = [
        'notes' => 'string',
        'consultation_date' => 'datetime'
    ];

    public static array $rules = [
        'appointment_id' => 'nullable',
        'notes' => 'nullable|string|max:65535',
        'created_by' => 'nullable',
        'consultation_date' => 'required'
    ];

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Appointment::class, 'appointment_id');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Message::class, 'consultation_id');
    }
}
