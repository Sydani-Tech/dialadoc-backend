<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *      schema="ProgressReport",
 *      required={},
 *      @OA\Property(
 *          property="report_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="progress_description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      )
 * )
 */class ProgressReport extends Model
{
    use HasFactory;    public $table = 'progress_reports';

    public $fillable = [
        'plan_id',
        'created_by',
        'report_date',
        'progress_description'
    ];

    protected $casts = [
        'report_date' => 'date',
        'progress_description' => 'string'
    ];

    public static array $rules = [
        'plan_id' => 'nullable',
        'created_by' => 'nullable',
        'report_date' => 'nullable',
        'progress_description' => 'nullable|string|max:65535'
    ];

    public function plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\TreatmentPlan::class, 'plan_id');
    }
}
