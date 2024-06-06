<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProgressReportAPIRequest;
use App\Http\Requests\API\UpdateProgressReportAPIRequest;
use App\Models\ProgressReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProgressReportResource;

/**
 * Class ProgressReportController
 */

class ProgressReportAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/progress-reports",
     *      summary="getProgressReportList",
     *      tags={"ProgressReport"},
     *      description="Get all ProgressReports",
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
     *                  @OA\Items(ref="#/components/schemas/ProgressReport")
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
        $query = ProgressReport::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $progressReports = $query->get();

        return $this->sendResponse(ProgressReportResource::collection($progressReports), 'Progress Reports retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/progress-reports",
     *      summary="createProgressReport",
     *      tags={"ProgressReport"},
     *      description="Create ProgressReport",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProgressReport")
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
     *                  ref="#/components/schemas/ProgressReport"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProgressReportAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProgressReport $progressReport */
        $progressReport = ProgressReport::create($input);

        return $this->sendResponse(new ProgressReportResource($progressReport), 'Progress Report saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/progress-reports/{id}",
     *      summary="getProgressReportItem",
     *      tags={"ProgressReport"},
     *      description="Get ProgressReport",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProgressReport",
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
     *                  ref="#/components/schemas/ProgressReport"
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
        /** @var ProgressReport $progressReport */
        $progressReport = ProgressReport::find($id);

        if (empty($progressReport)) {
            return $this->sendError('Progress Report not found');
        }

        return $this->sendResponse(new ProgressReportResource($progressReport), 'Progress Report retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/progress-reports/{id}",
     *      summary="updateProgressReport",
     *      tags={"ProgressReport"},
     *      description="Update ProgressReport",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProgressReport",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProgressReport")
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
     *                  ref="#/components/schemas/ProgressReport"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProgressReportAPIRequest $request): JsonResponse
    {
        /** @var ProgressReport $progressReport */
        $progressReport = ProgressReport::find($id);

        if (empty($progressReport)) {
            return $this->sendError('Progress Report not found');
        }

        $progressReport->fill($request->all());
        $progressReport->save();

        return $this->sendResponse(new ProgressReportResource($progressReport), 'ProgressReport updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/progress-reports/{id}",
     *      summary="deleteProgressReport",
     *      tags={"ProgressReport"},
     *      description="Delete ProgressReport",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProgressReport",
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
        /** @var ProgressReport $progressReport */
        $progressReport = ProgressReport::find($id);

        if (empty($progressReport)) {
            return $this->sendError('Progress Report not found');
        }

        $progressReport->delete();

        return $this->sendSuccess('Progress Report deleted successfully');
    }
}
