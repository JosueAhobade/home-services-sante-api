<?php

namespace App\Customs\Services;
use App\Models\EmailVerificationOtp;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class EmailVerificationService
{

    /**
     * Send verification link to  an user
     */
    public function sendVerificationLink(object $user): void
    {
        Notification::send($user, new EmailVerificationNotification($this->generateVerificationLink($user->email)));
    }
    /**
     * Generate verfication link
     */
    public function generateVerificationLink(string $email): string
    {
        $checkIfTokenExists = EmailVerificationOtp::where('email',$email)->first();

        if($checkIfTokenExists)
            $checkIfTokenExists->delete();

        $token = Str::uuid();
        $url = config('app.url'). "?token=". $token . "&email" . $email;
        $saveToken = EmailVerificationOtp::create([
            "email"=>$email,
            "token"=>$token,
            "expire_at"=>now()->addMinutes(60),
        ]);
        if($saveToken)
            return $url;
    }
}
