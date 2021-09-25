<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function makeSuccess($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
            'status_code' => $code
        ];
        return Response::json($response);
    }

    public function makeSuccessWithoutMessage($result, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => '',
            'data' => $result,
            'status_code' => $code
        ];
        return Response::json($response);
    }

    public function makeError($errorArr, $errorMsg, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $errorMsg,
            'status_code' => $code,
            'data' => []
        ];

        if (!empty($errorArr)) {
            $response['data'] = $errorArr;
        }

        return Response::json($response);
    }
}
