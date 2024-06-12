<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Order",
 *      required={"order_date","order_type","status"},
 *      @OA\Property(
 *          property="order_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Order extends Model
{
    use HasFactory;
    public $table = 'orders';
    protected $primaryKey = 'order_id';

    public $fillable = [
        'prescription_id',
        'pharmacy_id',
        'consultation_id',
        'user_id',
        'order_date',
        'order_type',
        'status'
    ];

    protected $casts = [
        'order_date' => 'datetime'
    ];

    public static array $rules = [
        'prescription_id' => 'nullable',
        'pharmacy_id' => 'nullable',
        'consultation_id' => 'nullable',
        'user_id' => 'nullable',
        'order_date' => 'required',
        'order_type' => 'required',
        'status' => 'required'
    ];

    public function prescription(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Prescription::class, 'prescription_id');
    }

    public function pharmacy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pharmacy::class, 'pharmacy_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'payments');
    }
}
