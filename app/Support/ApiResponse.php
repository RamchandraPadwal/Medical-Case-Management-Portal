<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

/**
 * One consistent JSON shape for every API response:
 * { "success": bool, "data": ..., "message": "...", "errors": {...}? }
 */
class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200, array $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $extra), $status);
    }

    public static function error(string $message, int $status, array $errors = []): JsonResponse
    {
        $payload = ['success' => false, 'data' => null, 'message' => $message];

        if ($errors) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
