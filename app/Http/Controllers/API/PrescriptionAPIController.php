<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePrescriptionAPIRequest;
use App\Http\Requests\API\UpdatePrescriptionAPIRequest;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PrescriptionResource;

/**
 * Class PrescriptionController
 */

class PrescriptionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/prescriptions",
     *      summary="getPrescriptionList",
     *      tags={"Prescription"},
     *      description="Get all Prescriptions",
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
     *                  @OA\Items(ref="#/components/schemas/Prescription")
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
        $query = Prescription::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $prescriptions = $query->get();

        return $this->sendResponse(PrescriptionResource::collection($prescriptions), 'Prescriptions retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/prescriptions",
     *      summary="createPrescription",
     *      tags={"Prescription"},
     *      description="Create Prescription",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Prescription")
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
     *                  ref="#/components/schemas/Prescription"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePrescriptionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Prescription $prescription */
        $prescription = Prescription::create($input);

        return $this->sendResponse(new PrescriptionResource($prescription), 'Prescription saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/prescriptions/{id}",
     *      summary="getPrescriptionItem",
     *      tags={"Prescription"},
     *      description="Get Prescription",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Prescription",
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
     *                  ref="#/components/schemas/Prescription"
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
        /** @var Prescription $prescription */
        $prescription = Prescription::find($id);

        if (empty($prescription)) {
            return $this->sendError('Prescription not found');
        }

        return $this->sendResponse(new PrescriptionResource($prescription), 'Prescription retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/prescriptions/{id}",
     *      summary="updatePrescription",
     *      tags={"Prescription"},
     *      description="Update Prescription",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Prescription",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Prescription")
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
     *                  ref="#/components/schemas/Prescription"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePrescriptionAPIRequest $request): JsonResponse
    {
        /** @var Prescription $prescription */
        $prescription = Prescription::find($id);

        if (empty($prescription)) {
            return $this->sendError('Prescription not found');
        }

        $prescription->fill($request->all());
        $prescription->save();

        return $this->sendResponse(new PrescriptionResource($prescription), 'Prescription updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/prescriptions/{id}",
     *      summary="deletePrescription",
     *      tags={"Prescription"},
     *      description="Delete Prescription",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Prescription",
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
        /** @var Prescription $prescription */
        $prescription = Prescription::find($id);

        if (empty($prescription)) {
            return $this->sendError('Prescription not found');
        }

        $prescription->delete();

        return $this->sendSuccess('Prescription deleted successfully');
    }
}
