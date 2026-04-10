<?php

namespace App\Services;

class SapiCredentials
{
    public static function username(): ?string
    {
        return session('sapi_username')
            ?? config('services.sapi.username');
    }

    public static function password(): ?string
    {
        return session('sapi_password')
            ?? config('services.sapi.password');
    }

    public static function isConfigured(): bool
    {
        return self::username() && self::password();
    }
}
