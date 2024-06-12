<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Location",
 *      required={"city","state","country"},
 *      @OA\Property(
 *          property="city",
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
 *          property="country",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="postal_code",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class Location extends Model
{
    use HasFactory;

    public $table = 'locations';

    public $fillable = [
        'city',
        'state',
        'country',
        'postal_code'
    ];

    protected $primaryKey = 'location_id'; // Specify the primary key

    protected $casts = [
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'postal_code' => 'string'
    ];

    public static array $rules = [
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'nullable|string|max:20'
    ];

    public function doctors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Doctor::class, 'location_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'patients');
    }

    public function pharmacies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Pharmacy::class, 'location_id');
    }
}
