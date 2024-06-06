<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePharmacyAPIRequest;
use App\Http\Requests\API\UpdatePharmacyAPIRequest;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PharmacyResource;

/**
 * Class PharmacyController
 */

class PharmacyAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/pharmacies",
     *      summary="getPharmacyList",
     *      tags={"Pharmacy"},
     *      description="Get all Pharmacies",
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
     *                  @OA\Items(ref="#/components/schemas/Pharmacy")
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
        $query = Pharmacy::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $pharmacies = $query->get();

        return $this->sendResponse(PharmacyResource::collection($pharmacies), 'Pharmacies retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/pharmacies",
     *      summary="createPharmacy",
     *      tags={"Pharmacy"},
     *      description="Create Pharmacy",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Pharmacy")
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
     *                  ref="#/components/schemas/Pharmacy"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePharmacyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::create($input);

        return $this->sendResponse(new PharmacyResource($pharmacy), 'Pharmacy saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/pharmacies/{id}",
     *      summary="getPharmacyItem",
     *      tags={"Pharmacy"},
     *      description="Get Pharmacy",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pharmacy",
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
     *                  ref="#/components/schemas/Pharmacy"
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
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::find($id);

        if (empty($pharmacy)) {
            return $this->sendError('Pharmacy not found');
        }

        return $this->sendResponse(new PharmacyResource($pharmacy), 'Pharmacy retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/pharmacies/{id}",
     *      summary="updatePharmacy",
     *      tags={"Pharmacy"},
     *      description="Update Pharmacy",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pharmacy",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Pharmacy")
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
     *                  ref="#/components/schemas/Pharmacy"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePharmacyAPIRequest $request): JsonResponse
    {
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::find($id);

        if (empty($pharmacy)) {
            return $this->sendError('Pharmacy not found');
        }

        $pharmacy->fill($request->all());
        $pharmacy->save();

        return $this->sendResponse(new PharmacyResource($pharmacy), 'Pharmacy updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/pharmacies/{id}",
     *      summary="deletePharmacy",
     *      tags={"Pharmacy"},
     *      description="Delete Pharmacy",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Pharmacy",
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
        /** @var Pharmacy $pharmacy */
        $pharmacy = Pharmacy::find($id);

        if (empty($pharmacy)) {
            return $this->sendError('Pharmacy not found');
        }

        $pharmacy->delete();

        return $this->sendSuccess('Pharmacy deleted successfully');
    }
}
