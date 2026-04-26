<?php

namespace App\Http\Requests\Auth;

use App\Models\Admin;
use Carbon\CarbonInterval;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property string $email
 * @property string $password
 */
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
     * @return array<string, ValidationRule|array<mixed>|string>
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
     * @throws ValidationException
     */
    public function authenticate(): Admin
    {
        $this->ensureIsNotRateLimited();

        /** @var Admin|null $admin */
        $admin = Admin::where('email', (string) $this->string('email'))->first();

        if (! $admin || ! Auth::validate($this->only('email', 'password'))) {
            $this->hitRateLimiters();

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if ($admin->isLocked()) {
            $this->hitRateLimiters();

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $this->clearRateLimiters();

        return $admin;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $credentialLimited = RateLimiter::tooManyAttempts($this->throttleKey(), 5);
        $ipLimited = RateLimiter::tooManyAttempts($this->ipThrottleKey(), 20);

        if (! $credentialLimited && ! $ipLimited) {
            return;
        }

        event(new Lockout($this));

        $seconds = max(
            RateLimiter::availableIn($this->throttleKey()),
            RateLimiter::availableIn($this->ipThrottleKey()),
        );
        $humanWindow = CarbonInterval::seconds($seconds)->cascade()->forHumans(short: true);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => max(1, ceil($seconds / 60)),
            ]).' Silakan coba lagi dalam '.$humanWindow.'.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }

    public function ipThrottleKey(): string
    {
        return 'login-ip|'.$this->ip();
    }

    protected function hitRateLimiters(): void
    {
        RateLimiter::hit($this->throttleKey(), 60);
        RateLimiter::hit($this->ipThrottleKey(), 60);
    }

    protected function clearRateLimiters(): void
    {
        RateLimiter::clear($this->throttleKey());
        RateLimiter::clear($this->ipThrottleKey());
    }
}
