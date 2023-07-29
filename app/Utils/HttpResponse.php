<?php
namespace App\Utils;
class HttpResponse
{

  public static function success($data, $message = 'Data found', $code = 200)
  {
    return response()->json([
      'status' => 'success',
      'message' => $message,
      'data' => $data
    ], $code);
  }

  public static function error($message, $error_code = 500)
  {
    return response()->json([
      'status' => 'error',
      'message' => $message,
      'data' => []
    ], $error_code);
  }

  public static function not_found()
  {
    return response()->json([
      'status' => 'error',
      'message' => 'Data not found',
      'data' => []
    ], 404);
  }
}