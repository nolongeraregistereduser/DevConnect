<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
            'email' => ['required', 'string', 'email'],
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
        
        // Get the credentials from the request
        $email = $this->input('email');
        $password = $this->input('password');
        
        \Illuminate\Support\Facades\Log::info('Login attempt', ['email' => $email]);
        
        // Find user directly
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            \Illuminate\Support\Facades\Log::warning('Login failed - User not found', ['email' => $email]);
            
            throw ValidationException::withMessages([
                'email' => 'No account found with this email address.',
            ]);
        }
        
        // Verify password directly
        if (!\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            \Illuminate\Support\Facades\Log::warning('Login failed - Password mismatch', [
                'email' => $email,
                'password_length' => strlen($password),
                'user_password_hash_method' => substr($user->password, 0, 4) // First few chars indicate hash type
            ]);
            
            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect.',
            ]);
        }
        
        // Log the user in directly
        \Illuminate\Support\Facades\Auth::login($user, $this->boolean('remember'));
        
        \Illuminate\Support\Facades\Log::info('Login successful', ['email' => $email, 'user_id' => $user->id]);
        RateLimiter::clear($this->throttleKey());
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
            'email' => trans('auth.throttle', [
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
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
