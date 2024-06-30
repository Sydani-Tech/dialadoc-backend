<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Facility",
 *      required={"user_id"},
 *      @OA\Property(
 *          property="logo_url",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="facility_name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="role_in_facility",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="country",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="state",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="lga",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="working_hours",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="helpdesk_email",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="helpdesk_number",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="number_of_staff",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="year_of_inception",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="facility_type",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="cac_number",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="user_id",
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
 */ class Facility extends Model
{
    use HasFactory;
    public $table = 'facilities';

    public $fillable = [
        'logo_url',
        'facility_name',
        'role_in_facility',
        'country',
        'state',
        'lga',
        'working_hours',
        'helpdesk_email',
        'helpdesk_number',
        'number_of_staff',
        'year_of_inception',
        'facility_type',
        'cac_number',
        'user_id'
    ];

    protected $casts = [
        'logo_url' => 'string',
        'facility_name' => 'string',
        'role_in_facility' => 'string',
        'country' => 'string',
        'state' => 'string',
        'lga' => 'string',
        'working_hours' => 'string',
        'helpdesk_email' => 'string',
        'helpdesk_number' => 'string',
        'number_of_staff' => 'integer',
        'year_of_inception' => 'date',
        'facility_type' => 'string',
        'cac_number' => 'string',
        'user_id' => 'integer'
    ];

    public static array $rules = [
        'facility_name' => 'nullable|string',
        'role_in_facility' => 'nullable|string',
        'country' => 'nullable|string',
        'state' => 'nullable|string',
        'lga' => 'nullable|string',
        'working_hours' => 'nullable|string',
        'helpdesk_email' => 'nullable|string',
        'helpdesk_number' => 'nullable|string',
        'number_of_staff' => 'nullable|string',
        'year_of_inception' => 'nullable|string',
        'facility_type' => 'nullable|string',
        'cac_number' => 'nullable|string',
        'user_id' => 'required'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function patientRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PatientRecord::class, 'recommended_facility');
    }
}
