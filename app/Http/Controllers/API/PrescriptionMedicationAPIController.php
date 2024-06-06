<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePrescriptionMedicationAPIRequest;
use App\Http\Requests\API\UpdatePrescriptionMedicationAPIRequest;
use App\Models\PrescriptionMedication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PrescriptionMedicationResource;

/**
 * Class PrescriptionMedicationController
 */

class PrescriptionMedicationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/prescription-medications",
     *      summary="getPrescriptionMedicationList",
     *      tags={"PrescriptionMedication"},
     *      description="Get all PrescriptionMedications",
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
     *                  @OA\Items(ref="#/components/schemas/PrescriptionMedication")
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
        $query = PrescriptionMedication::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $prescriptionMedications = $query->get();

        return $this->sendResponse(PrescriptionMedicationResource::collection($prescriptionMedications), 'Prescription Medications retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/prescription-medications",
     *      summary="createPrescriptionMedication",
     *      tags={"PrescriptionMedication"},
     *      description="Create PrescriptionMedication",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/PrescriptionMedication")
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
     *                  ref="#/components/schemas/PrescriptionMedication"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePrescriptionMedicationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PrescriptionMedication $prescriptionMedication */
        $prescriptionMedication = PrescriptionMedication::create($input);

        return $this->sendResponse(new PrescriptionMedicationResource($prescriptionMedication), 'Prescription Medication saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/prescription-medications/{id}",
     *      summary="getPrescriptionMedicationItem",
     *      tags={"PrescriptionMedication"},
     *      description="Get PrescriptionMedication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PrescriptionMedication",
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
     *                  ref="#/components/schemas/PrescriptionMedication"
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
        /** @var PrescriptionMedication $prescriptionMedication */
        $prescriptionMedication = PrescriptionMedication::find($id);

        if (empty($prescriptionMedication)) {
            return $this->sendError('Prescription Medication not found');
        }

        return $this->sendResponse(new PrescriptionMedicationResource($prescriptionMedication), 'Prescription Medication retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/prescription-medications/{id}",
     *      summary="updatePrescriptionMedication",
     *      tags={"PrescriptionMedication"},
     *      description="Update PrescriptionMedication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PrescriptionMedication",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/PrescriptionMedication")
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
     *                  ref="#/components/schemas/PrescriptionMedication"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePrescriptionMedicationAPIRequest $request): JsonResponse
    {
        /** @var PrescriptionMedication $prescriptionMedication */
        $prescriptionMedication = PrescriptionMedication::find($id);

        if (empty($prescriptionMedication)) {
            return $this->sendError('Prescription Medication not found');
        }

        $prescriptionMedication->fill($request->all());
        $prescriptionMedication->save();

        return $this->sendResponse(new PrescriptionMedicationResource($prescriptionMedication), 'PrescriptionMedication updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/prescription-medications/{id}",
     *      summary="deletePrescriptionMedication",
     *      tags={"PrescriptionMedication"},
     *      description="Delete PrescriptionMedication",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of PrescriptionMedication",
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
        /** @var PrescriptionMedication $prescriptionMedication */
        $prescriptionMedication = PrescriptionMedication::find($id);

        if (empty($prescriptionMedication)) {
            return $this->sendError('Prescription Medication not found');
        }

        $prescriptionMedication->delete();

        return $this->sendSuccess('Prescription Medication deleted successfully');
    }
}
