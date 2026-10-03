<?php

namespace App\Response;

class ApiResponse
{
    public static function success($message = 'Success', $code = 200, $data = [], $pagination = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'data' => $data,
            'pagination' => $pagination,
        ], $code);
    }

    public static function error($message, $code = 500)
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
        ], $code);
    }
}