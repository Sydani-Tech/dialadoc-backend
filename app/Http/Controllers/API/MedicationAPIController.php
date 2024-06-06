<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMedicationAPIRequest;
use App\Http\Requests\API\UpdateMedicationAPIRequest;
use App\Models\Medication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MedicationResource;

/**
 * Class MedicationController
 */

class MedicationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/medications",
     *      summary="getMedicationList",
     *      tags={"Medication"},
     *      description="Get all Medications",
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
     *                  @OA\Items(ref="#/components/schemas/Medication")
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
        $query = Medication::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $medications = $query->get();

        return $this->sendResponse(MedicationResource::collection($medications), 'Medications retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/medications",
     *      summary="createMedication",
     *      tags={"Medication"},
     *      description="Create Medication",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Medication")
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
     *                  ref="#/components/schemas/Medication"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMedicationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Medication $medication */
        $medication = Medication::create($input);

        return $this->sendResponse(new MedicationResource($medication), 'Medication saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/medications/{id}",
     *      summary="getMedicationItem",
     *      tags={"Medication"},
     *      description="Get Medication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Medication",
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
     *                  ref="#/components/schemas/Medication"
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
        /** @var Medication $medication */
        $medication = Medication::find($id);

        if (empty($medication)) {
            return $this->sendError('Medication not found');
        }

        return $this->sendResponse(new MedicationResource($medication), 'Medication retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/medications/{id}",
     *      summary="updateMedication",
     *      tags={"Medication"},
     *      description="Update Medication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Medication",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Medication")
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
     *                  ref="#/components/schemas/Medication"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMedicationAPIRequest $request): JsonResponse
    {
        /** @var Medication $medication */
        $medication = Medication::find($id);

        if (empty($medication)) {
            return $this->sendError('Medication not found');
        }

        $medication->fill($request->all());
        $medication->save();

        return $this->sendResponse(new MedicationResource($medication), 'Medication updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/medications/{id}",
     *      summary="deleteMedication",
     *      tags={"Medication"},
     *      description="Delete Medication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Medication",
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
        /** @var Medication $medication */
        $medication = Medication::find($id);

        if (empty($medication)) {
            return $this->sendError('Medication not found');
        }

        $medication->delete();

        return $this->sendSuccess('Medication deleted successfully');
    }
}
