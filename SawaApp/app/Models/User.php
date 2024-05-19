<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code', // Only needed for verification
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateVerificationCode($phoneNumber)
    {
        $verificationCode = rand(100000, 999999);
        $this->verification_code = $verificationCode;
        $this->save();


        return null;
    }


    public function verifyPhoneNumber($phoneNumber, $verificationCode)
    {
        if ($phoneNumber === $this->phone_number && $verificationCode === $this->verification_code) {
            $this->verification_code = null; // Clear code after successful verification
            $this->save();
            return true;
        }
        return false;
    }
    public static function logout($user)
    {
        try {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error logging out'], 500);
        }
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function iptvSubscriptions()
    {
        return $this->hasMany(IptvSubscription::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    //     public function sendNotification($message, $type)
    // {
    //     $this->notifications()->create([
    //         'message' => $message,
    //         'type' => $type,
    //     ]);
    // }
    public function sendNotification($message, $type)
    {
        // Log the notification
        \Illuminate\Support\Facades\Log::info("Notification sent to user {$this->id}: $message");

        // Create the notification
        $this->notifications()->create([
            'type' => 'App\\Notifications\\UserNotification',
            'data' => json_encode(['message' => $message, 'type' => $type]),
        ]);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }
}
