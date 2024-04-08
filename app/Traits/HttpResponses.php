<?php

namespace app\Traits;

use \Illuminate\Http\JsonResponse;


trait HttpResponses
{
    /**

    Return Success Message
    @param $data
    @param $message
    @param $code
    @return JsonResponse
     */
    protected function success($data, $message = null, $code = 200): JsonResponse
    {

        return response()->json([
            'status' => 'Request Was Successful.',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    protected function error($data, $message = null, $code): JsonResponse
    {

        return response()->json([
            'status' => 'Error has occurred...',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
