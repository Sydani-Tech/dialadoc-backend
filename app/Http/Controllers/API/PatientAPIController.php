<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePatientRecordAPIRequest;
use App\Http\Requests\API\UpdatePatientRecordAPIRequest;
use App\Models\PatientRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PatientRecordResource;

/**
 * Class PatientRecordController
 */

class PatientRecordAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/patient-records",
     *      summary="getPatientRecordList",
     *      tags={"PatientRecord"},
     *      description="Get all PatientRecords",
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
     *                  @OA\Items(ref="#/components/schemas/PatientRecord")
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
        $query = PatientRecord::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $patientRecords = $query->get();

        return $this->sendResponse(PatientRecordResource::collection($patientRecords), 'Patient Records retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/patient-records/by-facility/{facility_id}",
     *      summary="getPatientRecordList",
     *      tags={"PatientRecord"},
     *      description="Get all PatientRecords referred to facility",
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
     *                  @OA\Items(ref="#/components/schemas/PatientRecord")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function referredPatientRecordsForFacility(Request $request, $facilityId): JsonResponse
    {
        $query = PatientRecord::query();
        $query->where('recommended_facility', $facilityId);

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $patientRecords = $query->get();

        return $this->sendResponse(PatientRecordResource::collection($patientRecords), 'Patient Records retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/patient-records",
     *      summary="createPatientRecord",
     *      tags={"PatientRecord"},
     *      description="Create PatientRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/PatientRecord")
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
     *                  ref="#/components/schemas/PatientRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePatientRecordAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PatientRecord $patientRecord */
        $patientRecord = PatientRecord::create($input);

        return $this->sendResponse(new PatientRecordResource($patientRecord), 'Patient Record saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/patient-records/{id}",
     *      summary="getPatientRecordItem",
     *      tags={"PatientRecord"},
     *      description="Get PatientRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PatientRecord",
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
     *                  ref="#/components/schemas/PatientRecord"
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
        /** @var PatientRecord $patientRecord */
        $patientRecord = PatientRecord::find($id);

        if (empty($patientRecord)) {
            return $this->sendError('Patient Record not found');
        }

        return $this->sendResponse(new PatientRecordResource($patientRecord), 'Patient Record retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/patient-records/appointment-patient-records/{appointment_id}",
     *      summary="getPatientRecordItem",
     *      tags={"PatientRecord"},
     *      description="Get PatientRecord By Appointment",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Appointment",
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
     *                  ref="#/components/schemas/PatientRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function patientRecordByAppointment($appointment_id): JsonResponse
    {
        /** @var PatientRecord $patientRecord */
        $patientRecord = PatientRecord::where('appointment_id', $appointment_id)->first();

        if (empty($patientRecord)) {
            return $this->sendError('Patient Record not found');
        }

        return $this->sendResponse(new PatientRecordResource($patientRecord), 'Patient Record retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/patient-records/{id}",
     *      summary="updatePatientRecord",
     *      tags={"PatientRecord"},
     *      description="Update PatientRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PatientRecord",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/PatientRecord")
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
     *                  ref="#/components/schemas/PatientRecord"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePatientRecordAPIRequest $request): JsonResponse
    {
        /** @var PatientRecord $patientRecord */
        $patientRecord = PatientRecord::find($id);

        if (empty($patientRecord)) {
            return $this->sendError('Patient Record not found');
        }

        $patientRecord->fill($request->all());
        $patientRecord->save();

        return $this->sendResponse(new PatientRecordResource($patientRecord), 'PatientRecord updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/patient-records/{id}",
     *      summary="deletePatientRecord",
     *      tags={"PatientRecord"},
     *      description="Delete PatientRecord",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PatientRecord",
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
        /** @var PatientRecord $patientRecord */
        $patientRecord = PatientRecord::find($id);

        if (empty($patientRecord)) {
            return $this->sendError('Patient Record not found');
        }

        $patientRecord->delete();

        return $this->sendSuccess('Patient Record deleted successfully');
    }
}
