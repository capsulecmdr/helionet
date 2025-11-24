<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class HelionetLogger
{
    public static function info(string $code, string $message, array $context = []): void
    {
        Log::info($message, array_merge(['code' => $code], $context));
    }

    public static function warn(string $code, string $message, array $context = []): void
    {
        Log::warning($message, array_merge(['code' => $code], $context));
    }

    public static function error(string $code, string $message, array $context = []): void
    {
        Log::error($message, array_merge(['code' => $code], $context));
    }
}