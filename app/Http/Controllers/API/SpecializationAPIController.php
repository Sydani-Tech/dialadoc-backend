<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSpecializationAPIRequest;
use App\Http\Requests\API\UpdateSpecializationAPIRequest;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SpecializationResource;

/**
 * Class SpecializationController
 */

class SpecializationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/specializations",
     *      summary="getSpecializationList",
     *      tags={"Specialization"},
     *      description="Get all Specializations",
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
     *                  @OA\Items(ref="#/components/schemas/Specialization")
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
        $query = Specialization::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $specializations = $query->get();

        return $this->sendResponse(SpecializationResource::collection($specializations), 'Specializations retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/specializations",
     *      summary="createSpecialization",
     *      tags={"Specialization"},
     *      description="Create Specialization",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Specialization")
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
     *                  ref="#/components/schemas/Specialization"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSpecializationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Specialization $specialization */
        $specialization = Specialization::create($input);

        return $this->sendResponse(new SpecializationResource($specialization), 'Specialization saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/specializations/{id}",
     *      summary="getSpecializationItem",
     *      tags={"Specialization"},
     *      description="Get Specialization",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialization",
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
     *                  ref="#/components/schemas/Specialization"
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
        /** @var Specialization $specialization */
        $specialization = Specialization::find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        return $this->sendResponse(new SpecializationResource($specialization), 'Specialization retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/specializations/{id}",
     *      summary="updateSpecialization",
     *      tags={"Specialization"},
     *      description="Update Specialization",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialization",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Specialization")
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
     *                  ref="#/components/schemas/Specialization"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSpecializationAPIRequest $request): JsonResponse
    {
        /** @var Specialization $specialization */
        $specialization = Specialization::find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        $specialization->fill($request->all());
        $specialization->save();

        return $this->sendResponse(new SpecializationResource($specialization), 'Specialization updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/specializations/{id}",
     *      summary="deleteSpecialization",
     *      tags={"Specialization"},
     *      description="Delete Specialization",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialization",
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
        /** @var Specialization $specialization */
        $specialization = Specialization::find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        $specialization->delete();

        return $this->sendSuccess('Specialization deleted successfully');
    }
}
