<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMedicalRecordAPIRequest;
use App\Http\Requests\API\UpdateMedicalRecordAPIRequest;
use App\Models\MedicalRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MedicalRecordResource;

/**
 * Class MedicalRecordController
 */

class MedicalRecordAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/medical-records",
     *      summary="getMedicalRecordList",
     *      tags={"MedicalRecord"},
     *      description="Get all MedicalRecords",
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/MedicalRecord")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = MedicalRecord::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $medicalRecords = $query->get();

        return $this->sendResponse(MedicalRecordResource::collection($medicalRecords), 'Medical Records retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/medical-records",
     *      summary="createMedicalRecord",
     *      tags={"MedicalRecord"},
     *      description="Create MedicalRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/MedicalRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMedicalRecordAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var MedicalRecord $medicalRecord */
        $medicalRecord = MedicalRecord::create($input);

        return $this->sendResponse(new MedicalRecordResource($medicalRecord), 'Medical Record saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/medical-records/{id}",
     *      summary="getMedicalRecordItem",
     *      tags={"MedicalRecord"},
     *      description="Get MedicalRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of MedicalRecord",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/MedicalRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var MedicalRecord $medicalRecord */
        $medicalRecord = MedicalRecord::find($id);

        if (empty($medicalRecord)) {
            return $this->sendError('Medical Record not found');
        }

        return $this->sendResponse(new MedicalRecordResource($medicalRecord), 'Medical Record retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/medical-records/{id}",
     *      summary="updateMedicalRecord",
     *      tags={"MedicalRecord"},
     *      description="Update MedicalRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of MedicalRecord",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/MedicalRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMedicalRecordAPIRequest $request): JsonResponse
    {
        /** @var MedicalRecord $medicalRecord */
        $medicalRecord = MedicalRecord::find($id);

        if (empty($medicalRecord)) {
            return $this->sendError('Medical Record not found');
        }

        $medicalRecord->fill($request->all());
        $medicalRecord->save();

        return $this->sendResponse(new MedicalRecordResource($medicalRecord), 'MedicalRecord updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/medical-records/{id}",
     *      summary="deleteMedicalRecord",
     *      tags={"MedicalRecord"},
     *      description="Delete MedicalRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of MedicalRecord",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var MedicalRecord $medicalRecord */
        $medicalRecord = MedicalRecord::find($id);

        if (empty($medicalRecord)) {
            return $this->sendError('Medical Record not found');
        }

        $medicalRecord->delete();

        return $this->sendSuccess('Medical Record deleted successfully');
    }
}
