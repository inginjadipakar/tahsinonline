<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Added for debugging
use Illuminate\Support\Facades\Hash; // Added for debugging
use App\Models\User; // Added for debugging

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $originalInput = $this->input('phone');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // 1. Cleaner Input (remove spaces, etc)
        $cleanPhone = preg_replace('/[^0-9]/', '', $originalInput);
        
        // 2. Normalized Input (force 62 prefix)
        $normalizedPhone = \App\Helpers\PhoneHelper::normalize($cleanPhone);

        \Illuminate\Support\Facades\Log::info('LOGIN ATTEMPT', [
            'original' => $originalInput,
            'clean' => $cleanInput,
            'normalized' => $normalizedPhone,
            'password_len' => strlen($password),
            'password_check' => Hash::check($password, User::where('phone', $normalizedPhone)->value('password')) ? 'MATCH' : 'FAIL',
            'user_exists' => User::where('phone', $normalizedPhone)->exists() ? 'YES' : 'NO'
        ]);

        // Attempt 1: Try with Normalized Phone (Standard)
        if (Auth::attempt(['phone' => $normalizedPhone, 'password' => $password], $remember)) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Attempt 2: Try with Cleaned Phone (Legacy Support for 08xxx)
        // Only if normalized is different (e.g. input was 08xxx)
        if ($cleanPhone !== $normalizedPhone) {
            if (Auth::attempt(['phone' => $cleanPhone, 'password' => $password], $remember)) {
                
                // Auto-migrate user to new format
                $user = Auth::user();
                $user->phone = $normalizedPhone;
                $user->saveQuietly(); // save without events if needed, or just save()

                RateLimiter::clear($this->throttleKey());
                return;
            }
        }

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'phone' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'phone' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('phone')).'|'.$this->ip());
    }
}
