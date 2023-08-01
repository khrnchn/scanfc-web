<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function return_paginated_api($isSuccess, $statusCode,  $message, $data, $error, $apiPaginator)
    {
        return response()->json([
            'is_success' => $isSuccess,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
            'errors' => $error,
            'paginator' => $apiPaginator

        ], $statusCode);
    }

    public function return_api($isSuccess, $statusCode,  $message, $data, $error)
    {
        return response()->json([
            'is_success' => $isSuccess,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
            'errors' => $error,

        ], $statusCode);
    }
}
