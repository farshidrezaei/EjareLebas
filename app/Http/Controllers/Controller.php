<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use phpDocumentor\Reflection\Types\Mixed_ as Mixed_Alias;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param     mixed $response
     * @param bool      $result
     * @param string    $message
     * @param int       $code
     * @param int       $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonReturn( $response, bool $result = true, string $message = '', int $code = 100, int $statusCode = 200 )
    {
        return response()->json( [
            'result' => $result,
            'code' => $code,
            'message' => $message,
            'response' => $response
        ], $statusCode );
    }

    protected const SUCCESS = 100;
    protected const VALIDATE_ERR = 101;
    protected const ACCOUNT_DISABLE_ERR = 102;
    protected const VERIFICATION_ERR = 103;
}
