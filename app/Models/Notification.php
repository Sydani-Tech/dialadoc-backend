<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Notification",
 *      required={"created_at"},
 *      @OA\Property(
 *          property="message",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="is_read",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */ class Notification extends Model
{
    use HasFactory;
    public $table = 'notifications';

    protected $primaryKey = 'notification_id';

    public $fillable = [
        'user_id',
        'message',
        'is_read'
    ];

    protected $casts = [
        'message' => 'string',
        'is_read' => 'boolean'
    ];

    public static array $rules = [
        'user_id' => 'nullable',
        'message' => 'nullable|string|max:65535',
        'is_read' => 'nullable|boolean',
        'created_at' => 'required'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
