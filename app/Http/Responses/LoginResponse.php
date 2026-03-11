<?php

namespace App\Http\Responses;

use App\Enums\UserRole;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role = auth()->user()->role;

        $redirectPath = match ($role) {
            UserRole::Admin, UserRole::Kasir => route('admin.dashboard'),
            default => config('fortify.home'),
        };

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($redirectPath);
    }
}
