<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): JsonResponse|RedirectResponse
    {
        // The user should already be authenticated by Fortify's registration process
        // But let's ensure they are logged in
        if ($user = $request->user()) {
            auth()->login($user);
        }
        
        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->intended(Fortify::redirects('register', config('fortify.home')));
    }
}