<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * 
     * @param type $status  This is required(true || false)
     * @param type $code    Error Code or success code
     * @param type $message This is message of code or any message with the response
     * @param type $data    If you want to send any return data with response
     */
    public function jsonResponse($status, $code = 200, $message = '', $data = []) {
        $responseData = [
            'status' => $status,
            'message' => $message,
//            'code' => $code,
            'data' => ($data === []) ? (object) $data : $data
        ];
        $headers = [];
        $options = 0;

        return response()->json($responseData, $code, $headers, $options);
    }

}
