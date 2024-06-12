<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="TestResult",
 *      required={},
 *      @OA\Property(
 *          property="test_name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="result",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="date_performed",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      )
 * )
 */ class TestResult extends Model
{
    use HasFactory;
    public $table = 'test_results';
    protected $primaryKey = 'test_result_id';

    public $fillable = [
        'record_id',
        'test_name',
        'result',
        'date_performed',
        'created_by'
    ];

    protected $casts = [
        'test_name' => 'string',
        'result' => 'string',
        'date_performed' => 'date'
    ];

    public static array $rules = [
        'record_id' => 'nullable',
        'test_name' => 'nullable|string|max:100',
        'result' => 'nullable|string|max:65535',
        'date_performed' => 'nullable',
        'created_by' => 'nullable'
    ];

    public function record(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\MedicalRecord::class, 'record_id');
    }
}
