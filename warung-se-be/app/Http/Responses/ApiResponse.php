<?php

namespace App\Responses;

class ApiResponse
{
    /**
     * Success response
     */
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()->toIso8601String()
        ], $code);
    }

    /**
     * Error response
     */
    public static function error($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()->toIso8601String()
        ], $code);
    }

    /**
     * Validation error response
     */
    public static function validationError($errors, $message = 'Validation Failed')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()->toIso8601String()
        ], 422);
    }

    /**
     * Unauthorized response
     */
    public static function unauthorized($message = 'Unauthorized')
    {
        return self::error($message, 401);
    }

    /**
     * Forbidden response
     */
    public static function forbidden($message = 'Forbidden')
    {
        return self::error($message, 403);
    }

    /**
     * Not found response
     */
    public static function notFound($message = 'Not Found')
    {
        return self::error($message, 404);
    }

    /**
     * Server error response
     */
    public static function serverError($message = 'Internal Server Error')
    {
        return self::error($message, 500);
    }

    /**
     * Created response
     */
    public static function created($data = null, $message = 'Resource created successfully')
    {
        return self::success($data, $message, 201);
    }
}
