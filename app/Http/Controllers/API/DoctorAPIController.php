<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\DoctorResource;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateDoctorAPIRequest;
use App\Http\Requests\API\UpdateDoctorAPIRequest;

/**
 * Class DoctorController
 */

class DoctorAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/doctors",
     *      summary="getDoctorList",
     *      tags={"Doctor"},
     *      description="Get all Doctors",
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
     *                  @OA\Items(ref="#/components/schemas/Doctor")
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
        $query = Doctor::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $doctors = $query->get();

        return $this->sendResponse(DoctorResource::collection($doctors), 'Doctors retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/doctors",
     *      summary="createDoctor",
     *      tags={"Doctor"},
     *      description="Create Doctor",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Doctor")
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
     *                  ref="#/components/schemas/Doctor"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDoctorAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Doctor $doctor */
        $doctor = Doctor::create($input);

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/doctors/{id}",
     *      summary="getDoctorItem",
     *      tags={"Doctor"},
     *      description="Get Doctor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Doctor",
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
     *                  ref="#/components/schemas/Doctor"
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
        /** @var Doctor $doctor */
        $doctor = Doctor::find($id);

        if (empty($doctor)) {
            return $this->sendError('Doctor not found');
        }

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/doctors/{id}",
     *      summary="updateDoctor",
     *      tags={"Doctor"},
     *      description="Update Doctor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Doctor",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Doctor")
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
     *                  ref="#/components/schemas/Doctor"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDoctorAPIRequest $request): JsonResponse
    {
        /** @var Doctor $doctor */
        $doctor = Doctor::find($id);

        if (empty($doctor)) {
            return $this->sendError('Doctor not found');
        }

        $doctor->fill($request->all());
        $doctor->save();

        $user = User::find($doctor->user_id);

        if(!empty($user)) {
            $user->is_profile_updated == 1;
            $user->save();
        }

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/doctors/{id}",
     *      summary="deleteDoctor",
     *      tags={"Doctor"},
     *      description="Delete Doctor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Doctor",
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
        /** @var Doctor $doctor */
        $doctor = Doctor::find($id);

        if (empty($doctor)) {
            return $this->sendError('Doctor not found');
        }

        $doctor->delete();

        return $this->sendSuccess('Doctor deleted successfully');
    }
}
