<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Response sukses
     */
    public static function success($data = null, string $message = "Success", int $status = 200): JsonResponse
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "data" => $data
        ], $status);
    }

    /**
     * Response berhasil dibuat / created
     */
    public static function created($data = null, string $message = "Resource created"): JsonResponse
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "data" => $data
        ], 201);
    }

    /**
     * Response unauthorized / gagal autentikasi
     */
    public static function unauthorized(string $message = "Unauthorized"): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message
        ], 401);
    }

    /**
     * Response forbidden / gagal akses
     */
    public static function forbidden(string $message = "Forbidden"): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message
        ], 403);
    }

    /**
     * Response error umum / bad request
     */
    public static function error(string $message = "Error", int $status = 400, $data = null): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
            "data" => $data
        ], $status);
    }
}
