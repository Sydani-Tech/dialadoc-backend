<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppointmentAPIRequest;
use App\Http\Requests\API\UpdateAppointmentAPIRequest;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AppointmentResource;

/**
 * Class AppointmentController
 */

class AppointmentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/appointments",
     *      summary="getAppointmentList",
     *      tags={"Appointment"},
     *      description="Get all Appointments",
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
     *                  @OA\Items(ref="#/components/schemas/Appointment")
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
        $query = Appointment::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $appointments = $query->get();

        return $this->sendResponse(AppointmentResource::collection($appointments), 'Appointments retrieved successfully');
    }

        /**
     * @OA\Get(
     *      path="/appointments/by-patient",
     *      summary="getAppointmentList for a patient",
     *      tags={"Appointment"},
     *      description="Get all Appointments for a specific patient",
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
     *                  @OA\Items(ref="#/components/schemas/Appointment")
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
        $query = Appointment::query();
        $query->whereHas('consultation', function ($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        });

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $appointments = $query->get();

        return $this->sendResponse(AppointmentResource::collection($appointments), 'Appointments retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/appointments",
     *      summary="createAppointment",
     *      tags={"Appointment"},
     *      description="Create Appointment",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Appointment")
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
     *                  ref="#/components/schemas/Appointment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAppointmentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Appointment $appointment */
        $appointment = Appointment::create($input);

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/appointments/{id}",
     *      summary="getAppointmentItem",
     *      tags={"Appointment"},
     *      description="Get Appointment",
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
     *                  ref="#/components/schemas/Appointment"
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
        /** @var Appointment $appointment */
        $appointment = Appointment::find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/appointments/consultation-appointment/{consultation_id}",
     *      summary="getAppointmentItem",
     *      tags={"Appointment"},
     *      description="Get Consultation's Appointment",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Consultation",
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
     *                  ref="#/components/schemas/Appointment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function appointmentByConsultation($consultation_id): JsonResponse
    {
        /** @var Appointment $appointment */
        $appointment = Appointment::where('consultation_id', $consultation_id)->first();

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/appointments/{id}",
     *      summary="updateAppointment",
     *      tags={"Appointment"},
     *      description="Update Appointment",
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
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Appointment")
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
     *                  ref="#/components/schemas/Appointment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAppointmentAPIRequest $request): JsonResponse
    {
        /** @var Appointment $appointment */
        $appointment = Appointment::find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        $appointment->fill($request->all());
        $appointment->save();

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/appointments/{id}",
     *      summary="deleteAppointment",
     *      tags={"Appointment"},
     *      description="Delete Appointment",
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
        /** @var Appointment $appointment */
        $appointment = Appointment::find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        $appointment->delete();

        return $this->sendSuccess('Appointment deleted successfully');
    }
}
