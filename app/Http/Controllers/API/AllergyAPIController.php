<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAllergyAPIRequest;
use App\Http\Requests\API\UpdateAllergyAPIRequest;
use App\Models\Allergy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AllergyResource;

/**
 * Class AllergyController
 */

class AllergyAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/allergies",
     *      summary="getAllergyList",
     *      tags={"Allergy"},
     *      description="Get all Allergies",
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
     *                  @OA\Items(ref="#/components/schemas/Allergy")
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
        $query = Allergy::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $allergies = $query->get();

        return $this->sendResponse(AllergyResource::collection($allergies), 'Allergies retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/allergies",
     *      summary="createAllergy",
     *      tags={"Allergy"},
     *      description="Create Allergy",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Allergy")
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
     *                  ref="#/components/schemas/Allergy"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAllergyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Allergy $allergy */
        $allergy = Allergy::create($input);

        return $this->sendResponse(new AllergyResource($allergy), 'Allergy saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/allergies/{id}",
     *      summary="getAllergyItem",
     *      tags={"Allergy"},
     *      description="Get Allergy",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Allergy",
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
     *                  ref="#/components/schemas/Allergy"
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
        /** @var Allergy $allergy */
        $allergy = Allergy::find($id);

        if (empty($allergy)) {
            return $this->sendError('Allergy not found');
        }

        return $this->sendResponse(new AllergyResource($allergy), 'Allergy retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/allergies/{id}",
     *      summary="updateAllergy",
     *      tags={"Allergy"},
     *      description="Update Allergy",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Allergy",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Allergy")
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
     *                  ref="#/components/schemas/Allergy"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAllergyAPIRequest $request): JsonResponse
    {
        /** @var Allergy $allergy */
        $allergy = Allergy::find($id);

        if (empty($allergy)) {
            return $this->sendError('Allergy not found');
        }

        $allergy->fill($request->all());
        $allergy->save();

        return $this->sendResponse(new AllergyResource($allergy), 'Allergy updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/allergies/{id}",
     *      summary="deleteAllergy",
     *      tags={"Allergy"},
     *      description="Delete Allergy",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Allergy",
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
        /** @var Allergy $allergy */
        $allergy = Allergy::find($id);

        if (empty($allergy)) {
            return $this->sendError('Allergy not found');
        }

        $allergy->delete();

        return $this->sendSuccess('Allergy deleted successfully');
    }
}
