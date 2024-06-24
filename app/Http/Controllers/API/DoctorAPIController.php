<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        try {
            $input = $request->all();
            $user = Auth::user();
            $input['user_id'] = $user->id;
            /** @var Doctor $doctor */
            $doctor = Doctor::create($input);

            // Save MDCN License
            $mdcnLicense = $request->file('mdcn_license');

            if ($mdcnLicense) {
                $path_folder = public_path('storage/doctors-profile/');
                $mdcnName = rand() . '.' . $mdcnLicense->getClientOriginalExtension();
                $mdcnLicense->move($path_folder, $mdcnName);
                $doctor->mdcn_license = $mdcnName;
            }

            // Save CPD Annual License
            $cpdAnnualLicense = $request->file('cpd_annual_license');

            if ($cpdAnnualLicense) {
                $path_folder = public_path('storage/doctors-profile/');
                $cpdName = rand() . '.' . $cpdAnnualLicense->getClientOriginalExtension();
                $cpdAnnualLicense->move($path_folder, $cpdName);
                $doctor->cpd_annual_license = $cpdName;
            }

            $doctor->save();

            return $this->sendResponse(new DoctorResource($doctor), 'Doctor saved successfully');
        } catch (\Throwable $th) {
            return $this->sendError('An error occured while trying to save profile');
        }
    }

    /**
     * @OA\Get(
     *      path="/doctors/{user_id}",
     *      summary="getDoctorItem",
     *      tags={"Doctor"},
     *      description="Get Doctor",
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
    public function show($user_id): JsonResponse
    {
        /** @var Doctor $doctor */
        $doctor = Doctor::where('user_id', $user_id)->first();

        if (empty($doctor)) {
            return $this->sendError('Doctor not found');
        }

        return $this->sendResponse(new DoctorResource($doctor), 'Doctor retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/doctors/{user_id}",
     *      summary="updateDoctor",
     *      tags={"Doctor"},
     *      description="Update Doctor",
     *      @OA\Parameter(
     *          name="user_id",
     *          description="id of User",
     *          @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Doctor")
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
    public function update($user_id, UpdateDoctorAPIRequest $request): JsonResponse
    {
        try {
            $doctor = Doctor::where('user_id', $user_id)->first();

            if (!$doctor) {
                return $this->sendError('Doctor not found');
            }

            $doctor->fill($request->validated());
            $doctor->save();

            $user = $doctor->user;

            if ($user) {
                $user->is_profile_updated = 1;
                $user->save();
            }

            // Save MDCN License
            $mdcnLicense = $request->file('mdcn_license');

            if ($mdcnLicense) {
                $path_folder = public_path('storage/doctors-profile/');
                $oldMdcnLicense = $path_folder . '/' . $doctor->mdcn_license;

                if (File::exists($oldMdcnLicense)) {
                    File::delete($oldMdcnLicense);
                }

                $mdcnName = rand() . '.' . $mdcnLicense->getClientOriginalExtension();
                $mdcnLicense->move($path_folder, $mdcnName);
                $doctor->mdcn_license = $mdcnName;
            }

            // Save CPD Annual License
            $cpdAnnualLicense = $request->file('cpd_annual_license');

            if ($cpdAnnualLicense) {
                $path_folder = public_path('storage/doctors-profile/');
                $oldCpdAnnualLicense = $path_folder . '/' . $doctor->cpd_annual_license;

                if (File::exists($oldCpdAnnualLicense)) {
                    File::delete($oldCpdAnnualLicense);
                }

                $cpdName = rand() . '.' . $cpdAnnualLicense->getClientOriginalExtension();
                $cpdAnnualLicense->move($path_folder, $cpdName);
                $doctor->cpd_annual_license = $cpdName;
            }

            $doctor->save();

            return $this->sendResponse(new DoctorResource($doctor), 'Doctor updated successfully');
        } catch (\Throwable $th) {
            return $this->sendError('An error occured while trying to update profile');
        }
    }

    /**
     * @OA\Delete(
     *      path="/doctors/{user_id}",
     *      summary="deleteDoctor",
     *      tags={"Doctor"},
     *      description="Delete Doctor",
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
    public function destroy($user_id): JsonResponse
    {
        /** @var Doctor $doctor */
        $doctor = Doctor::where('user_id', $user_id)->first();

        if (empty($doctor)) {
            return $this->sendError('Doctor not found');
        }

        $doctor->delete();

        return $this->sendSuccess('Doctor deleted successfully');
    }
}
