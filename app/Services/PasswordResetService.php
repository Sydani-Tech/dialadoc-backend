<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class PasswordResetService
{
    public function sendResetToken($email)
    {
        $token = Str::random(6);
        $tokenHash = bcrypt($token);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $tokenHash, 'created_at' => Carbon::now()]
        );

        try {
            Mail::raw("Your OTP code is: $token", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your Password Reset OTP Code');
            });
        } catch (\Throwable $th) {
            return false;
        }

        return $token;
    }

    public function verifyResetToken($email, $otp)
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($record && bcrypt($otp) == $record->token && !$this->tokenExpired($record->created_at)) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return true;
        }

        return false;
    }

    protected function tokenExpired($createdAt)
    {
        $expires = 60; // Minutes
        return Carbon::parse($createdAt)->addMinutes($expires)->isPast();
    }
}
