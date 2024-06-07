<?php

namespace App\Http\Response;

class ApiResponse
{
    public function apiResponse(string $message, mixed $data = [], int $code = 404)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            ], $code);
    }
}