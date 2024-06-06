<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInsuranceAPIRequest;
use App\Http\Requests\API\UpdateInsuranceAPIRequest;
use App\Models\Insurance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\InsuranceResource;

/**
 * Class InsuranceController
 */

class InsuranceAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/insurances",
     *      summary="getInsuranceList",
     *      tags={"Insurance"},
     *      description="Get all Insurances",
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
     *                  @OA\Items(ref="#/components/schemas/Insurance")
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
        $query = Insurance::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $insurances = $query->get();

        return $this->sendResponse(InsuranceResource::collection($insurances), 'Insurances retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/insurances",
     *      summary="createInsurance",
     *      tags={"Insurance"},
     *      description="Create Insurance",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Insurance")
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
     *                  ref="#/components/schemas/Insurance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateInsuranceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Insurance $insurance */
        $insurance = Insurance::create($input);

        return $this->sendResponse(new InsuranceResource($insurance), 'Insurance saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/insurances/{id}",
     *      summary="getInsuranceItem",
     *      tags={"Insurance"},
     *      description="Get Insurance",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Insurance",
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
     *                  ref="#/components/schemas/Insurance"
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
        /** @var Insurance $insurance */
        $insurance = Insurance::find($id);

        if (empty($insurance)) {
            return $this->sendError('Insurance not found');
        }

        return $this->sendResponse(new InsuranceResource($insurance), 'Insurance retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/insurances/{id}",
     *      summary="updateInsurance",
     *      tags={"Insurance"},
     *      description="Update Insurance",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Insurance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Insurance")
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
     *                  ref="#/components/schemas/Insurance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateInsuranceAPIRequest $request): JsonResponse
    {
        /** @var Insurance $insurance */
        $insurance = Insurance::find($id);

        if (empty($insurance)) {
            return $this->sendError('Insurance not found');
        }

        $insurance->fill($request->all());
        $insurance->save();

        return $this->sendResponse(new InsuranceResource($insurance), 'Insurance updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/insurances/{id}",
     *      summary="deleteInsurance",
     *      tags={"Insurance"},
     *      description="Delete Insurance",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Insurance",
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
        /** @var Insurance $insurance */
        $insurance = Insurance::find($id);

        if (empty($insurance)) {
            return $this->sendError('Insurance not found');
        }

        $insurance->delete();

        return $this->sendSuccess('Insurance deleted successfully');
    }
}
