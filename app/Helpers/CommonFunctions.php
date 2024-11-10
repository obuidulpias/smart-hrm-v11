<?php
use Illuminate\Support\Facades\DB;
function apiResponse($data_array, $msg = "Data saved successfully", $status = "success", $header = [])
{

    return response()->json([
        'status' => $status,
        'message' => $msg,
        'data_list' => $data_array
    ], 200);

}

function errorResponse($msg = "The transaction is not successfully", $e = [])
{
    DB::rollback();
    $response = [
        'status' => 'failed',
        'message' => $msg,
        'errors' => !empty($e) ? $e->getMessage() : ''
    ];
    return $response;
}

