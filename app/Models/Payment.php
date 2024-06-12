<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Payment",
 *      required={"payment_date","status"},
 *      @OA\Property(
 *          property="amount",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="number",
 *          format="number"
 *      ),
 *      @OA\Property(
 *          property="currency",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="payment_date",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Payment extends Model
{
    use HasFactory;
    public $table = 'payments';
    protected $primaryKey = 'payment_id';

    public $fillable = [
        'user_id',
        'order_id',
        'amount',
        'currency',
        'payment_date',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'currency' => 'string',
        'payment_date' => 'datetime'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'order_id' => 'nullable',
        'amount' => 'nullable|numeric',
        'currency' => 'nullable|string|max:10',
        'payment_date' => 'required',
        'status' => 'required'
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
