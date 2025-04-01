<?php

namespace App\Traits;

trait ApiResponses
{

    protected function ok($message, $data = []): \Illuminate\Http\JsonResponse
    {
        return $this->success($message, $data);
    }

    protected function success($message, $data, $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
            'status'  => $statusCode
        ], $statusCode);
    }

    protected function error($errors = [], $statusCode = null): \Illuminate\Http\JsonResponse
    {
        if(is_string($errors)){
            return response()->json([
                'message' => $errors,
                'status'  => $statusCode
            ], $statusCode);
        }
        return response()->json([
            'errors' => $errors,
        ], $statusCode);
    }
}
