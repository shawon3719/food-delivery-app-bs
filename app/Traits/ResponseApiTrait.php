<?php


namespace App\Traits;


use App\Data\Constants;
use Illuminate\Validation\ValidationException;

trait ResponseApiTrait
{
    public function success($data, $message){
        $response = [
            'status' => 'success',
            'code' => Constants::HTTP_OK,
            'message' => $message,
            'result' => $data,
        ];
        return response()->json($response, Constants::HTTP_OK);
    }
    public function successSaveData($message){
        $response['status'] = 'success';
        $response['message'] = $message;
        return response()->json($response, Constants::HTTP_OK);
    }
    public function successApiResponse($response, $message){
        return $response->additional([
            'status' => 'success',
            'status_code' => Constants::HTTP_OK,
            'message' => $message
        ])->response()->setStatusCode(Constants::HTTP_OK);
    }

    public function successArray($response, $message){
        $response['status'] = 'success';
        $response['message'] = $message;
        return response()->json($response, Constants::HTTP_OK);
    }



    public function failure($e){
        if ($e instanceof ValidationException) {
            $response['data'] = array();
            $response['status'] = 'error';
            $response['message'] = $e->validator->errors()->first();
            return response()->json($response, Constants::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response['data'] = array();
        $response['status'] = 'error';
        $response['message'] = $e->validator->errors()->first();
        $response['error_message'] = $e->getMessage();
        return response()->json($response, Constants::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function error($message)
    {
        return response()->json([
            'status_code' => Constants::HTTP_EXPECTATION_FAILED,
            'message' => $message,
            'status' => 'error',
        ], Constants::HTTP_EXPECTATION_FAILED);

    }
    public function failureSaveData($message){
        $response['status'] = 'error';
        $response['message'] = $message;
        return response()->json($response, Constants::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getFailureArray($message){
        $response['data'] = array();
        $response['status'] = 'error';
        $response['message'] = $message;
        return $response;
    }

//    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
//    {
//        // Check the params
//        if(!$message) return response()->json(['message' => 'Message is required'], 500);
//
//        // Send the response
//        if($isSuccess) {
//            return response()->json([
//                'message' => $message,
//                'error' => false,
//                'code' => $statusCode,
//                'results' => $data
//            ], $statusCode);
//        } else {
//            return response()->json([
//                'message' => $message,
//                'error' => true,
//                'code' => $statusCode,
//            ], $statusCode);
//        }
//    }
//
//    /**
//     * Send any success response
//     *
//     * @param   string          $message
//     * @param   array|object    $data
//     * @param   integer         $statusCode
//     */
//    public function success($message, $data, $statusCode = 200)
//    {
//        return $this->coreResponse($message, $data, $statusCode);
//    }
//
//    /**
//     * Send any error response
//     *
//     * @param   string          $message
//     * @param   integer         $statusCode
//     */
//    public function error($message, $statusCode = 500)
//    {
//        return $this->coreResponse($message, null, $statusCode, false);
//    }

}
