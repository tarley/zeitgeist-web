<?php

function WrapData($data, $msg = "", $hasError = false)
{
    $result = array("data" => $data, "msg" => $msg, "hasError" => $hasError);
    return $result;
}

function ToJson($data)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    $response = json_encode($data);
    
    Log::Debug(print_r($response, true));
    
    echo $response;
    exit;
}

function ToWrappedJson($data, $msg = "", $hasError = false)
{
    ToJson(WrapData($data, $msg, $hasError));
}

function ToErrorJson($msg)
{
    ToJson(WrapData(null, $msg, true));
}

function ToExceptionJson(Exception $e)
{
    $msg = $e->getMessage();
    ToJson(WrapData(null, $msg, true));
}


