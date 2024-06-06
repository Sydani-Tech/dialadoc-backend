<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateConsentTypeAPIRequest;
use App\Http\Requests\API\UpdateConsentTypeAPIRequest;
use App\Models\ConsentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ConsentTypeResource;

/**
 * Class ConsentTypeController
 */

class ConsentTypeAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/consent-types",
     *      summary="getConsentTypeList",
     *      tags={"ConsentType"},
     *      description="Get all ConsentTypes",
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
     *                  @OA\Items(ref="#/components/schemas/ConsentType")
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
        $query = ConsentType::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $consentTypes = $query->get();

        return $this->sendResponse(ConsentTypeResource::collection($consentTypes), 'Consent Types retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/consent-types",
     *      summary="createConsentType",
     *      tags={"ConsentType"},
     *      description="Create ConsentType",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ConsentType")
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
     *                  ref="#/components/schemas/ConsentType"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConsentTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ConsentType $consentType */
        $consentType = ConsentType::create($input);

        return $this->sendResponse(new ConsentTypeResource($consentType), 'Consent Type saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/consent-types/{id}",
     *      summary="getConsentTypeItem",
     *      tags={"ConsentType"},
     *      description="Get ConsentType",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ConsentType",
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
     *                  ref="#/components/schemas/ConsentType"
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
        /** @var ConsentType $consentType */
        $consentType = ConsentType::find($id);

        if (empty($consentType)) {
            return $this->sendError('Consent Type not found');
        }

        return $this->sendResponse(new ConsentTypeResource($consentType), 'Consent Type retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/consent-types/{id}",
     *      summary="updateConsentType",
     *      tags={"ConsentType"},
     *      description="Update ConsentType",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ConsentType",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ConsentType")
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
     *                  ref="#/components/schemas/ConsentType"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConsentTypeAPIRequest $request): JsonResponse
    {
        /** @var ConsentType $consentType */
        $consentType = ConsentType::find($id);

        if (empty($consentType)) {
            return $this->sendError('Consent Type not found');
        }

        $consentType->fill($request->all());
        $consentType->save();

        return $this->sendResponse(new ConsentTypeResource($consentType), 'ConsentType updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/consent-types/{id}",
     *      summary="deleteConsentType",
     *      tags={"ConsentType"},
     *      description="Delete ConsentType",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ConsentType",
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
        /** @var ConsentType $consentType */
        $consentType = ConsentType::find($id);

        if (empty($consentType)) {
            return $this->sendError('Consent Type not found');
        }

        $consentType->delete();

        return $this->sendSuccess('Consent Type deleted successfully');
    }
}
