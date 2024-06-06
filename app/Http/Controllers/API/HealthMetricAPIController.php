<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHealthMetricAPIRequest;
use App\Http\Requests\API\UpdateHealthMetricAPIRequest;
use App\Models\HealthMetric;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\HealthMetricResource;

/**
 * Class HealthMetricController
 */

class HealthMetricAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/health-metrics",
     *      summary="getHealthMetricList",
     *      tags={"HealthMetric"},
     *      description="Get all HealthMetrics",
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
     *                  @OA\Items(ref="#/components/schemas/HealthMetric")
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
        $query = HealthMetric::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $healthMetrics = $query->get();

        return $this->sendResponse(HealthMetricResource::collection($healthMetrics), 'Health Metrics retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/health-metrics",
     *      summary="createHealthMetric",
     *      tags={"HealthMetric"},
     *      description="Create HealthMetric",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/HealthMetric")
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
     *                  ref="#/components/schemas/HealthMetric"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHealthMetricAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var HealthMetric $healthMetric */
        $healthMetric = HealthMetric::create($input);

        return $this->sendResponse(new HealthMetricResource($healthMetric), 'Health Metric saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/health-metrics/{id}",
     *      summary="getHealthMetricItem",
     *      tags={"HealthMetric"},
     *      description="Get HealthMetric",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HealthMetric",
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
     *                  ref="#/components/schemas/HealthMetric"
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
        /** @var HealthMetric $healthMetric */
        $healthMetric = HealthMetric::find($id);

        if (empty($healthMetric)) {
            return $this->sendError('Health Metric not found');
        }

        return $this->sendResponse(new HealthMetricResource($healthMetric), 'Health Metric retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/health-metrics/{id}",
     *      summary="updateHealthMetric",
     *      tags={"HealthMetric"},
     *      description="Update HealthMetric",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HealthMetric",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/HealthMetric")
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
     *                  ref="#/components/schemas/HealthMetric"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHealthMetricAPIRequest $request): JsonResponse
    {
        /** @var HealthMetric $healthMetric */
        $healthMetric = HealthMetric::find($id);

        if (empty($healthMetric)) {
            return $this->sendError('Health Metric not found');
        }

        $healthMetric->fill($request->all());
        $healthMetric->save();

        return $this->sendResponse(new HealthMetricResource($healthMetric), 'HealthMetric updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/health-metrics/{id}",
     *      summary="deleteHealthMetric",
     *      tags={"HealthMetric"},
     *      description="Delete HealthMetric",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HealthMetric",
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
        /** @var HealthMetric $healthMetric */
        $healthMetric = HealthMetric::find($id);

        if (empty($healthMetric)) {
            return $this->sendError('Health Metric not found');
        }

        $healthMetric->delete();

        return $this->sendSuccess('Health Metric deleted successfully');
    }
}
