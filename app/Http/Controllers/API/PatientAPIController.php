<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PatientResource;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePatientAPIRequest;
use App\Http\Requests\API\UpdatePatientAPIRequest;

/**
 * Class PatientController
 */

class PatientAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/patients",
     *      summary="getPatientList",
     *      tags={"Patient"},
     *      description="Get all Patients",
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
     *                  @OA\Items(ref="#/components/schemas/Patient")
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
        $query = Patient::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $patients = $query->get();

        return $this->sendResponse(PatientResource::collection($patients), 'Patients retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/patients",
     *      summary="createPatient",
     *      tags={"Patient"},
     *      description="Create Patient",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Patient")
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
     *                  ref="#/components/schemas/Patient"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePatientAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user->id;

        /** @var Patient $patient */
        $patient = Patient::create($input);

        $doctor = $this->match_patient_with_doc($patient);

        if ($doctor) {
            $patient->update(['doctor_id' => $doctor->doctor_id]);
        }

        $user->update(['is_profile_updated' => 1]);

        return $this->sendResponse(new PatientResource($patient), 'Patient saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/patients/{user_id}",
     *      summary="getPatientItem",
     *      tags={"Patient"},
     *      description="Get Patient",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="id of User",
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
     *                  ref="#/components/schemas/Patient"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($user_id): JsonResponse
    {
        /** @var Patient $patient */
        $patient = Patient::where('user_id', $user_id)->first();

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        return $this->sendResponse(new PatientResource($patient), 'Patient retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/patients/by-user/{user_id}",
     *      summary="getPatientItem",
     *      tags={"Patient"},
     *      description="Get Patient By User ID",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="id of User",
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
     *                  ref="#/components/schemas/Patient"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getByUserId($user_id): JsonResponse
    {
        /** @var Patient $patient */
        $patient = Patient::where('user_id', $user_id)->first();

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        return $this->sendResponse(new PatientResource($patient), 'Patient retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/patients/{user_id}",
     *      summary="updatePatient",
     *      tags={"Patient"},
     *      description="Update Patient",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="id of User",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Patient")
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
     *                  ref="#/components/schemas/Patient"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($user_id, UpdatePatientAPIRequest $request): JsonResponse
    {
        /** @var Patient $patient */
        $patient = Patient::where('user_id', $user_id)->first();

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        $user = $patient->user;

        $patient->fill($request->all());
        $patient->save();

        if (!empty($user)) {
            $user->is_profile_updated = 1;
            $user->save();
        }

        return $this->sendResponse(new PatientResource($patient), 'Patient updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/patients/{user_id}",
     *      summary="deletePatient",
     *      tags={"Patient"},
     *      description="Delete Patient",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="user_id",
     *          description="id of User",
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
    public function destroy($user_id): JsonResponse
    {
        /** @var Patient $patient */
        $patient = Patient::where('user_id', $user_id)->first();

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        if ($patient->appointments()->exists()) {
            return $this->sendError('Cannot delete doctor because it has associated appointments.');
        }

        $patient->delete();

        return $this->sendSuccess('Patient deleted successfully');
    }
}
