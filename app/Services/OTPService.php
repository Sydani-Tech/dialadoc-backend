<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class OTPService
{
    public function generateOTP(User $user, $type = 'email_verification')
    {
        $otp = rand(100000, 999999);
        $cacheKey = $this->getCacheKey($user, $type);
        Cache::put($cacheKey, $otp, now()->addMinutes(10));

        try {
            Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your OTP Code');
            });
        } catch (\Throwable $th) {
            return false;
        }

        return $otp;
    }

    public function verifyOTP(User $user, $otp, $type = 'email_verification')
    {
        $cacheKey = $this->getCacheKey($user, $type);
        $cachedOtp = Cache::get($cacheKey);

        if ($cachedOtp && $cachedOtp == $otp) {
            Cache::forget($cacheKey);
            return true;
        }

        return false;
    }

    private function getCacheKey(User $user, $type)
    {
        return 'otp_' . $type . '_' . $user->id;
    }
}
