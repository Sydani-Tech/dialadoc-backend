<?php

namespace App\Http\Controllers\API;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ConsultationResource;
use App\Http\Requests\API\CreateConsultationAPIRequest;
use App\Http\Requests\API\UpdateConsultationAPIRequest;

/**
 * Class ConsultationController
 */

class ConsultationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/consultations",
     *      summary="getConsultationList",
     *      tags={"Consultation"},
     *      description="Get all Consultations",
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
     *                  @OA\Items(ref="#/components/schemas/Consultation")
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

        $query = Consultation::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $consultations = $query->get();

        return $this->sendResponse(ConsultationResource::collection($consultations), 'Consultations retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/consultations/by-doctor/{doctor_id}",
     *      summary="getConsultationListByDoctor",
     *      tags={"Consultation"},
     *      description="Get all Doctor's Consultations",
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
     *                  @OA\Items(ref="#/components/schemas/Consultation")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getConsultationsByDoctor(Request $request, $doctorId = null): JsonResponse
    {
        if ($doctorId === null) {
            $doctor = Auth::user()->doctorProfile;
            $doctorId = $doctor->doctor_id;
        }

        $query = Consultation::query();
        $query->where('doctor_id', $doctorId);

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $consultations = $query->get();

        return $this->sendResponse(ConsultationResource::collection($consultations), 'Consultations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/consultations",
     *      summary="createConsultation",
     *      tags={"Consultation"},
     *      description="Create Consultation",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Consultation")
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
     *                  ref="#/components/schemas/Consultation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConsultationAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['status'] = 'pending';
        /** @var Consultation $consultation */
        $consultation = Consultation::create($input);

        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/consultations/{id}",
     *      summary="getConsultationItem",
     *      tags={"Consultation"},
     *      description="Get Consultation",
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
     *                  ref="#/components/schemas/Consultation"
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
        /** @var Consultation $consultation */
        $consultation = Consultation::find($id);

        if (empty($consultation)) {
            return $this->sendError('Consultation not found');
        }

        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/consultations/{id}",
     *      summary="updateConsultation",
     *      tags={"Consultation"},
     *      description="Update Consultation",
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
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Consultation")
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
     *                  ref="#/components/schemas/Consultation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConsultationAPIRequest $request): JsonResponse
    {
        /** @var Consultation $consultation */
        $consultation = Consultation::find($id);

        if (empty($consultation)) {
            return $this->sendError('Consultation not found');
        }

        $consultation->fill($request->all());
        $consultation->save();

        return $this->sendResponse(new ConsultationResource($consultation), 'Consultation updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/consultations/{id}",
     *      summary="deleteConsultation",
     *      tags={"Consultation"},
     *      description="Delete Consultation",
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
        /** @var Consultation $consultation */
        $consultation = Consultation::find($id);

        if (empty($consultation)) {
            return $this->sendError('Consultation not found');
        }

        $consultation->delete();

        return $this->sendSuccess('Consultation deleted successfully');
    }
}
