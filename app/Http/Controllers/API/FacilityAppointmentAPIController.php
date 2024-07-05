<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFacilityAppointmentAPIRequest;
use App\Http\Requests\API\UpdateFacilityAppointmentAPIRequest;
use App\Models\FacilityAppointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FacilityAppointmentResource;

/**
 * Class FacilityAppointmentController
 */

class FacilityAppointmentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/facility-appointments",
     *      summary="getFacilityAppointmentList",
     *      tags={"FacilityAppointment"},
     *      description="Get all FacilityAppointments",
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
     *                  @OA\Items(ref="#/components/schemas/FacilityAppointment")
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
        $query = FacilityAppointment::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $facilityAppointments = $query->get();

        return $this->sendResponse(FacilityAppointmentResource::collection($facilityAppointments), 'Facility Appointments retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/facility-appointments/by-facility/{facility_id}",
     *      summary="getFacilityAppointmentList Belonging to a specific facility",
     *      tags={"FacilityAppointment"},
     *      description="Get all FacilityAppointments belonging to a specific facility",
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
     *                  @OA\Items(ref="#/components/schemas/FacilityAppointment")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function appointmentsByFacility(Request $request, $facilityId): JsonResponse
    {
        $query = FacilityAppointment::query();
        $query->where('facility_id', $facilityId);

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $facilityAppointments = $query->get();

        return $this->sendResponse(FacilityAppointmentResource::collection($facilityAppointments), 'Facility Appointments retrieved successfully');
    }

        /**
     * @OA\Get(
     *      path="/facility-appointments/by-patient/{facility_id}",
     *      summary="getFacilityAppointmentList Belonging to a specific patient",
     *      tags={"FacilityAppointment"},
     *      description="Get all FacilityAppointments belonging to a specific patient",
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
     *                  @OA\Items(ref="#/components/schemas/FacilityAppointment")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function appointmentsByPatient(Request $request, $patientId): JsonResponse
    {
        $query = FacilityAppointment::query();
        $query->whereHas('patientRecord', function ($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        });

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $facilityAppointments = $query->get();

        return $this->sendResponse(FacilityAppointmentResource::collection($facilityAppointments), 'Facility Appointments retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/facility-appointments",
     *      summary="createFacilityAppointment",
     *      tags={"FacilityAppointment"},
     *      description="Create FacilityAppointment",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/FacilityAppointment")
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
     *                  ref="#/components/schemas/FacilityAppointment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFacilityAppointmentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var FacilityAppointment $facilityAppointment */
        $facilityAppointment = FacilityAppointment::create($input);

        return $this->sendResponse(new FacilityAppointmentResource($facilityAppointment), 'Facility Appointment saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/facility-appointments/{id}",
     *      summary="getFacilityAppointmentItem",
     *      tags={"FacilityAppointment"},
     *      description="Get FacilityAppointment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of FacilityAppointment",
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
     *                  ref="#/components/schemas/FacilityAppointment"
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
        /** @var FacilityAppointment $facilityAppointment */
        $facilityAppointment = FacilityAppointment::find($id);

        if (empty($facilityAppointment)) {
            return $this->sendError('Facility Appointment not found');
        }

        return $this->sendResponse(new FacilityAppointmentResource($facilityAppointment), 'Facility Appointment retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/facility-appointments/{id}",
     *      summary="updateFacilityAppointment",
     *      tags={"FacilityAppointment"},
     *      description="Update FacilityAppointment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of FacilityAppointment",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/FacilityAppointment")
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
     *                  ref="#/components/schemas/FacilityAppointment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFacilityAppointmentAPIRequest $request): JsonResponse
    {
        /** @var FacilityAppointment $facilityAppointment */
        $facilityAppointment = FacilityAppointment::find($id);

        if (empty($facilityAppointment)) {
            return $this->sendError('Facility Appointment not found');
        }

        $facilityAppointment->fill($request->all());
        $facilityAppointment->save();

        return $this->sendResponse(new FacilityAppointmentResource($facilityAppointment), 'FacilityAppointment updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/facility-appointments/{id}",
     *      summary="deleteFacilityAppointment",
     *      tags={"FacilityAppointment"},
     *      description="Delete FacilityAppointment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of FacilityAppointment",
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
        /** @var FacilityAppointment $facilityAppointment */
        $facilityAppointment = FacilityAppointment::find($id);

        if (empty($facilityAppointment)) {
            return $this->sendError('Facility Appointment not found');
        }

        $facilityAppointment->delete();

        return $this->sendSuccess('Facility Appointment deleted successfully');
    }
}
