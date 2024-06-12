<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Review",
 *      required={"review_date"},
 *      @OA\Property(
 *          property="review_text",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="review_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Review extends Model
{
    use HasFactory;
    public $table = 'reviews';
    protected $primaryKey = 'review_id';

    public $fillable = [
        'doctor_id',
        'patient_id',
        'rating',
        'review_text',
        'review_date'
    ];

    protected $casts = [
        'review_text' => 'string',
        'review_date' => 'datetime'
    ];

    public static array $rules = [
        'doctor_id' => 'nullable',
        'patient_id' => 'nullable',
        'rating' => 'nullable',
        'review_text' => 'nullable|string|max:65535',
        'review_date' => 'required'
    ];

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'patient_id');
    }

    public function doctor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_id');
    }
}
