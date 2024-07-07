<?php

namespace App\Http\Controllers\API;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FacilityResource;
use App\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\API\CreateFacilityAPIRequest;
use App\Http\Requests\API\UpdateFacilityAPIRequest;

/**
 * Class FacilityController
 */

class FacilityAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/facilities",
     *      summary="getFacilityList",
     *      tags={"Facility"},
     *      description="Get all Facilities",
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
     *                  @OA\Items(ref="#/components/schemas/Facility")
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
        $query = Facility::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $facilities = $query->get();

        return $this->sendResponse(FacilityResource::collection($facilities), 'Facilities retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/facilities",
     *      summary="createFacility",
     *      tags={"Facility"},
     *      description="Create Facility",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Facility")
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
     *                  ref="#/components/schemas/Facility"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFacilityAPIRequest $request): JsonResponse
    {
        $user = Auth::user();

        $facility = Facility::where('user_id', $user->id)->first();

        $input = $request->all();
        $facility->fill($input);

        // /** @var Facility $facility */
        // $facility = Facility::create($input);

        $facility->fill($request->all());
        $facility->save();

        $user->is_profile_updated = 1;
        $user->save();

        return $this->sendResponse(new FacilityResource($facility), 'Facility saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/facilities/{user_id}",
     *      summary="getFacilityItem",
     *      tags={"Facility"},
     *      description="Get Facility By User",
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
     *                  ref="#/components/schemas/Facility"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($userId): JsonResponse
    {
        /** @var Facility $facility */
        $facility = Facility::where('user_id', $userId)->first();

        if (empty($facility)) {
            return $this->sendError('Facility not found');
        }

        return $this->sendResponse(new FacilityResource($facility), 'Facility retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/facilities/{user_id}",
     *      summary="updateFacility",
     *      tags={"Facility"},
     *      description="Update Facility",
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
     *        @OA\JsonContent(ref="#/components/schemas/Facility")
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
     *                  ref="#/components/schemas/Facility"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($userId, UpdateFacilityAPIRequest $request): JsonResponse
    {
        /** @var Facility $facility */
        $facility = Facility::where('user_id', $userId)->first();

        if (empty($facility)) {
            return $this->sendError('Facility not found');
        }

        $facility->fill($request->all());
        $facility->save();

        $user = $facility->user;

        if (!empty($user)) {
            $user->is_profile_updated = 1;
            $user->save();
        }

        return $this->sendResponse(new FacilityResource($facility), 'Facility updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/facilities/{user_id}",
     *      summary="deleteFacility",
     *      tags={"Facility"},
     *      description="Delete Facility",
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
    public function destroy($userId): JsonResponse
    {
        /** @var Facility $facility */
        $facility = Facility::where('user_id', $userId)->first();

        if (empty($facility)) {
            return $this->sendError('Facility not found');
        }

        $facility->delete();

        return $this->sendSuccess('Facility deleted successfully');
    }

    // get facilities referrals by facility id
    /**
     * @OA\Get(
     *      path="/facility-referrals/{facility_id}",
     *      summary="getFacilityReferrals",
     *      tags={"Facility"},
     *      description="Get Facility Referrals",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="facility_id",
     *          description="id of Facility",
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
     *                  property="data"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getReferrals($facilityId): JsonResponse
    {
        // I was woried about creatig n+1 queries so i did this
        // you can refactor this if you want to

        $results = DB::table('patient_records', 'ptr')
            ->where('ptr.recommended_facility', '=', $facilityId)
            ->join('patients', 'ptr.patient_id', '=', 'patients.patient_id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('appointments', 'ptr.appointment_id', '=', 'appointments.appointment_id')
            ->join('consultations', 'appointments.consultation_id', '=', 'consultations.consultation_id')
            ->join('doctors', 'consultations.doctor_id', '=', 'doctors.doctor_id')
            ->join('users as doc', 'doctors.user_id', '=', 'doc.id')
            ->select(
                'users.name as patient_name',
                'patients.state as patient_state',
                'patients.lga as patient_lga',
                'patients.patient_id as patient_id',
                'patients.gender as patient_gender',
                'doc.name as doctor_name',
                'doctors.doctor_id as doctor_id',
                'consultations.consultation_id as consultation_id',
                'appointments.appointment_id as appointment_id',
                'ptr.update_type',
                'ptr.suspected_illness',
                'ptr.findings',
                'ptr.recommended_tests',
                'ptr.prescriptions'
            )
            ->get();

        $groupedResults = $results->groupBy('patient_name')->map(function ($patientRecords, $patientName) {
            $firstRecord = $patientRecords->first();

            return [
                'patient_name' => $patientName,
                'patient_id' => $firstRecord->patient_id,
                'patient_state' => $firstRecord->patient_state,
                'patient_lga' => $firstRecord->patient_lga,
                'patient_gender' => $firstRecord->patient_gender,
                'patient_records' => $patientRecords->map(function ($record) {
                    return [
                        'doctor_name' => $record->doctor_name,
                        'doctor_id' => $record->doctor_id,
                        'consultation_id' => $record->consultation_id,
                        'appointment_id' => $record->appointment_id,
                        'update_type' => $record->update_type,
                        'suspected_illness' => $record->suspected_illness,
                        'findings' => $record->findings,
                        'recommended_tests' => $record->recommended_tests,
                        'prescriptions' => $record->prescriptions
                    ];
                })->toArray()
            ];
        })->values()->toArray();

        // $data = [];

        // foreach ($results as $result => $result) {
        //     $patient_name = $result['patient_name'];
        //     if (!isset($data[$patient_name])) {
        //         $data[$patient_name] = [
        //             'patient_name' => $patient_name,
        //             'patient_state' => $result['patient_state'],
        //             'patient_lga' => $result['patient_lga'],
        //             'patient_gender' => $result['patient_gender'],
        //             'patient_records' => []
        //         ];
        //     }

        //     // Add the current record to the patient's records
        //     $data[$patient_name]['patient_records'][] = [
        //         'doctor_name' => $result['doctor_name'],
        //         'update_type' => $result['update_type'],
        //         'suspected_illness' => $result['suspected_illness'],
        //         'findings' => $result['findings'],
        //         'recommended_tests' => $result['recommended_tests'],
        //         'prescriptions' => $result['prescriptions']
        //     ];
        // }

        // $data = Collection::make(['data' => $data]);
        return $this->sendResponse($groupedResults, 'Facility referrals retrieved successfully');
    }
}
