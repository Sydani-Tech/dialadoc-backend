<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTreatmentPlanAPIRequest;
use App\Http\Requests\API\UpdateTreatmentPlanAPIRequest;
use App\Models\TreatmentPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TreatmentPlanResource;

/**
 * Class TreatmentPlanController
 */

class TreatmentPlanAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/treatment-plans",
     *      summary="getTreatmentPlanList",
     *      tags={"TreatmentPlan"},
     *      description="Get all TreatmentPlans",
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
     *                  @OA\Items(ref="#/components/schemas/TreatmentPlan")
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
        $query = TreatmentPlan::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $treatmentPlans = $query->get();

        return $this->sendResponse(TreatmentPlanResource::collection($treatmentPlans), 'Treatment Plans retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/treatment-plans",
     *      summary="createTreatmentPlan",
     *      tags={"TreatmentPlan"},
     *      description="Create TreatmentPlan",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TreatmentPlan")
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
     *                  ref="#/components/schemas/TreatmentPlan"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTreatmentPlanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TreatmentPlan $treatmentPlan */
        $treatmentPlan = TreatmentPlan::create($input);

        return $this->sendResponse(new TreatmentPlanResource($treatmentPlan), 'Treatment Plan saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/treatment-plans/{id}",
     *      summary="getTreatmentPlanItem",
     *      tags={"TreatmentPlan"},
     *      description="Get TreatmentPlan",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TreatmentPlan",
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
     *                  ref="#/components/schemas/TreatmentPlan"
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
        /** @var TreatmentPlan $treatmentPlan */
        $treatmentPlan = TreatmentPlan::find($id);

        if (empty($treatmentPlan)) {
            return $this->sendError('Treatment Plan not found');
        }

        return $this->sendResponse(new TreatmentPlanResource($treatmentPlan), 'Treatment Plan retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/treatment-plans/{id}",
     *      summary="updateTreatmentPlan",
     *      tags={"TreatmentPlan"},
     *      description="Update TreatmentPlan",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TreatmentPlan",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TreatmentPlan")
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
     *                  ref="#/components/schemas/TreatmentPlan"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTreatmentPlanAPIRequest $request): JsonResponse
    {
        /** @var TreatmentPlan $treatmentPlan */
        $treatmentPlan = TreatmentPlan::find($id);

        if (empty($treatmentPlan)) {
            return $this->sendError('Treatment Plan not found');
        }

        $treatmentPlan->fill($request->all());
        $treatmentPlan->save();

        return $this->sendResponse(new TreatmentPlanResource($treatmentPlan), 'TreatmentPlan updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/treatment-plans/{id}",
     *      summary="deleteTreatmentPlan",
     *      tags={"TreatmentPlan"},
     *      description="Delete TreatmentPlan",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TreatmentPlan",
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
        /** @var TreatmentPlan $treatmentPlan */
        $treatmentPlan = TreatmentPlan::find($id);

        if (empty($treatmentPlan)) {
            return $this->sendError('Treatment Plan not found');
        }

        $treatmentPlan->delete();

        return $this->sendSuccess('Treatment Plan deleted successfully');
    }
}
