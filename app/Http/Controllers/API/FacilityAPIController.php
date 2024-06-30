<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFacilityAPIRequest;
use App\Http\Requests\API\UpdateFacilityAPIRequest;
use App\Models\Facility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FacilityResource;

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
        $input = $request->all();

        /** @var Facility $facility */
        $facility = Facility::create($input);

        return $this->sendResponse(new FacilityResource($facility), 'Facility saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/facilities/{user_id}",
     *      summary="getFacilityItem",
     *      tags={"Facility"},
     *      description="Get Facility By User",
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
}
