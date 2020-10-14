<?php


namespace App\Traits;


trait JsonResponseTrait
{
    protected function success($data = [], $status = 200)
    {
        return response([
            'code' => $status,
            'data' => $data,
            'message' => 'ok',
        ], $status);
    }

    protected function failure($data = [], $message = 'Unprocessable Entity response', $status = 422)
    {
        return response([
            'code' => $status,
            'data' => $data,
            'message' => $message,
        ], $status);
    }
}
