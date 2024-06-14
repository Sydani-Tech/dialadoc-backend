<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Str;
use App\Services\OTPService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\PasswordResetService;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\VerifyEmailRequest;
use App\Http\Requests\API\Auth\PasswordResetRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;

/**     @OA\Components(
 *         @OA\Schema(
 *             schema="RegisterRequest",
 *             type="object",
 *             required={"name", "email", "password", "password_confirmation", "role"},
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 format="name"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 format="password"
 *             ),
 *             @OA\Property(
 *                 property="password_confirmation",
 *                 type="string",
 *                 format="password"
 *             ),
 *             @OA\Property(
 *                 property="role",
 *                 type="string"
 *             )
 *         ),
 *         @OA\Schema(
 *             schema="LoginRequest",
 *             type="object",
 *             required={"email", "password"},
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 format="password"
 *             )
 *         ),
 *         @OA\Schema(
 *             schema="VerifyEmailRequest",
 *             type="object",
 *             required={"otp"},
 *             @OA\Property(
 *                 property="otp",
 *                 type="string"
 *             )
 *         ),
 *         @OA\Schema(
 *             schema="PasswordResetRequest",
 *             type="object",
 *             required={"email"},
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email"
 *             )
 *         ),
 *         @OA\Schema(
 *             schema="ResetPasswordRequest",
 *             type="object",
 *             required={"email", "otp", "password", "password_confirmation"},
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email"
 *             ),
 *             @OA\Property(
 *                 property="otp",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 format="password"
 *             ),
 *             @OA\Property(
 *                 property="password_confirmation",
 *                 type="string",
 *                 format="password"
 *             )
 *         )
 *     )
 */
class AuthController extends AppBaseController
{
    /**
     * @OA\Post(
     *      path="/auth/register",
     *      summary="register",
     *      tags={"Register"},
     *      description="Register new user",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/RegisterRequest")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();

        try {
            DB::beginTransaction();
            // Create user
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password'])
            ]);

            // Assign role
            $role = Role::where('name', '=', $input['role'])->first();
            if (!empty($role)) {
                $user->assignRole($role);
            }

            if ($role->name == "patient") {
                $patient = Patient::create([
                    'user_id' => $user->id
                ]);
            } else if ($role->name == "doctor") {
                $doctor = Doctor::create([
                    'user_id' => $user->id
                ]);
            }

            // Create user token
            $token = $user->createToken(Str::slug(config('app.name') . '_auth_token', '_'))->plainTextToken;
            $permissions = $user->getAllPermissions();
            $user->role = $user->roles()->first();

            // TODO: send verification mail

            DB::commit();

            // Send response
            return response()->json([
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token
                ],
                'status' => true,
                'message' => 'User registered successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('An error occured');
        }
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      summary="login",
     *      tags={"Login"},
     *      description="Login a user",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/LoginRequest")
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/LoginRequest")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login(LoginRequest $request)
    {
        $input = $request->all();

        $user = User::where('email', $input['email'])->first();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login details'
            ]);
        }

        if (!Hash::check($input['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password does not match'
            ]);
        }

        $token = $user->createToken(Str::slug(config('app.name') . '_auth_token', '_'))->plainTextToken;
        $permissions = $user->getAllPermissions();
        $user->role = $user->roles()->first();

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
                // 'permissions' => $permissions
            ],
            'status' => true,
            'message' => 'Login successful'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      summary="logout",
     *      tags={"Logout"},
     *      description="Logout a user",
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function logout()
    {
        $user =  Auth::user();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'Logout was not successful'
            ]);
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/auth/email-verification",
     *      summary="email verification",
     *      tags={"Email verification request"},
     *      description="Request OTP",
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function emailVerification()
    {
        $otpService = new OTPService;

        $user = Auth::user();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => true,
                'message' => 'Email has already been verified!',
            ]);
        }

        $result = $otpService->generateOTP($user);

        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to send mail'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to your mail'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/auth/verify-email",
     *      summary="Verify Email",
     *      tags={"Verify Email Request"},
     *      description="Submit OTP",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VerifyEmailRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function verifyEmail(VerifyEmailRequest $request)
    {
        $otpService = new OTPService;

        $user = Auth::user();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => true,
                'message' => 'Email has already been verified!',
            ]);
        }

        if (!$otpService->verifyOTP($user, $request->otp)) {
            return response()->json([
                'status' => true,
                'message' => 'Invalid OTP',
            ], 400);
        }

        $user = User::where('email', $user->email)->first();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->markEmailAsVerified();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/auth/send-reset-token",
     *      summary="Password Request",
     *      tags={"Password Reset Token Request"},
     *      description="Submit OTP",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PasswordResetRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function passwordResetToken(PasswordResetRequest $request)
    {
        $passwordResetService = new PasswordResetService;

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $result = $passwordResetService->sendResetToken($email);

        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to send mail'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to your mail for password reset'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/auth/reset-password",
     *      summary="Reset Passowrd",
     *      tags={"Reset Password"},
     *      description="Send OTP, Email, Password and Confirmation",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ResetPasswordRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $passwordResetService = new PasswordResetService;

        $email = $request->input('email');
        $otp = $request->input('otp');
        $password = $request->input('password');

        if (!$passwordResetService->verifyResetToken($email, $otp)) {
            return response()->json([
                'status' => true,
                'message' => 'Invalid OTP',
            ], 400);
        }

        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->password = Hash::make($password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully'
        ]);
    }
}
