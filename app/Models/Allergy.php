<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Allergy",
 *      required={"name","value","patient_id"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="patient_id",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
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
 *      )
 * )
 */ class Allergy extends Model
{
    use HasFactory;

    public $table = 'allergies';

    public $fillable = [
        'name',
        'value',
        'patient_id',
        'other_allergies'
    ];

    protected $casts = [
        'name' => 'string',
        'value' => 'string',
        'patient_id' => 'integer',
        'other_allergies' => 'json' // Assuming other_allergies is stored as JSON
    ];

    public static array $rules = [
        'name' => 'required',
        'value' => 'required',
        'patient_id' => 'required'
    ];

    /**
     * Define the relationship with OtherAllergy model if exists
     */
    public function otherAllergies()
    {
        return $this->hasMany(OtherAllergy::class);
    }
}
