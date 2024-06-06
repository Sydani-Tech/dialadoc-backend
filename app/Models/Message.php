<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="Message",
 *      required={"sent_at"},
 *      @OA\Property(
 *          property="message_text",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="sent_at",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class Message extends Model
{
    use HasFactory;    public $table = 'messages';

    public $fillable = [
        'consultation_id',
        'sender_id',
        'receiver_id',
        'message_text',
        'sent_at'
    ];

    protected $casts = [
        'message_text' => 'string',
        'sent_at' => 'datetime'
    ];

    public static array $rules = [
        'consultation_id' => 'nullable',
        'sender_id' => 'nullable',
        'receiver_id' => 'nullable',
        'message_text' => 'nullable|string|max:65535',
        'sent_at' => 'required'
    ];

    public function consultation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Consultation::class, 'consultation_id');
    }

    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id');
    }

    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'receiver_id');
    }
}
