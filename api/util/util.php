<?php

function CreateLog($msg)
{
    $date = date("Y_m_d");
    $time = date("H:i:s T");
    $ip = $_SERVER ['REMOTE_ADDR'];

    // Nome do arquivo:
    $file = LOG_DIR . "Log-$date.log";

    // Texto a ser impresso no log:
    $text = "[$time] \t [$ip] \t $msg \n";

    $handler = fopen("$file", "ab");
    fwrite($handler, $text);
    fclose($handler);
}

function WrapData($data, $msg = "", $hasError = false)
{
    $result = array("data" => $data, "msg" => $msg, "hasError" => $hasError);
    return $result;
}

function ToJson($data)
{
    header("Content-type: application/json");

    echo json_encode($data);
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
    CreateLog($msg);
    ToJson(WrapData(null, $msg, true));
}


