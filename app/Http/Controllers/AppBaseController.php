<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use InfyOm\Generator\Utils\ResponseUtil;

/**
 * @OA\Server(url="/api")
 * @OA\Info(
 *   title="DialaDoc APIs",
 *   version="1.0.0"
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return response()->json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return response()->json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function uploadFiles($file, $path)
    {
        if ($file) {
            $fName = rand() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $fName);
            return $fName;
        }

        return null;
    }

    public function match_patient_with_doc($patient)
    {
        $doctor = Doctor::where('state', $patient->state)
            ->where('lga', $patient->lga)
            ->first();

        if (!$doctor) {
            $doctor = Doctor::where('state', $patient->state)
                ->first();
        }

        if (!$doctor) {
            $doctor = Doctor::whereNotNull('state')
                ->first();
        }

        return $doctor;
    }
}
