<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVitalSignAPIRequest;
use App\Http\Requests\API\UpdateVitalSignAPIRequest;
use App\Models\VitalSign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\VitalSignResource;

/**
 * Class VitalSignController
 */

class VitalSignAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/vital-signs",
     *      summary="getVitalSignList",
     *      tags={"VitalSign"},
     *      description="Get all VitalSigns",
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
     *                  @OA\Items(ref="#/components/schemas/VitalSign")
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
        $query = VitalSign::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $vitalSigns = $query->get();

        return $this->sendResponse(VitalSignResource::collection($vitalSigns), 'Vital Signs retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/vital-signs",
     *      summary="createVitalSign",
     *      tags={"VitalSign"},
     *      description="Create VitalSign",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/VitalSign")
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
     *                  ref="#/components/schemas/VitalSign"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateVitalSignAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var VitalSign $vitalSign */
        $vitalSign = VitalSign::create($input);

        return $this->sendResponse(new VitalSignResource($vitalSign), 'Vital Sign saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/vital-signs/{id}",
     *      summary="getVitalSignItem",
     *      tags={"VitalSign"},
     *      description="Get VitalSign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of VitalSign",
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
     *                  ref="#/components/schemas/VitalSign"
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
        /** @var VitalSign $vitalSign */
        $vitalSign = VitalSign::find($id);

        if (empty($vitalSign)) {
            return $this->sendError('Vital Sign not found');
        }

        return $this->sendResponse(new VitalSignResource($vitalSign), 'Vital Sign retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/vital-signs/{id}",
     *      summary="updateVitalSign",
     *      tags={"VitalSign"},
     *      description="Update VitalSign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of VitalSign",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/VitalSign")
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
     *                  ref="#/components/schemas/VitalSign"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateVitalSignAPIRequest $request): JsonResponse
    {
        /** @var VitalSign $vitalSign */
        $vitalSign = VitalSign::find($id);

        if (empty($vitalSign)) {
            return $this->sendError('Vital Sign not found');
        }

        $vitalSign->fill($request->all());
        $vitalSign->save();

        return $this->sendResponse(new VitalSignResource($vitalSign), 'VitalSign updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/vital-signs/{id}",
     *      summary="deleteVitalSign",
     *      tags={"VitalSign"},
     *      description="Delete VitalSign",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of VitalSign",
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
        /** @var VitalSign $vitalSign */
        $vitalSign = VitalSign::find($id);

        if (empty($vitalSign)) {
            return $this->sendError('Vital Sign not found');
        }

        $vitalSign->delete();

        return $this->sendSuccess('Vital Sign deleted successfully');
    }
}
