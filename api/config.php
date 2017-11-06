<?php

date_default_timezone_set('America/Sao_Paulo');

define('CONTEXT_NAME', '/zeitgeist-web/api/');
define('LOG_DIR', $_SERVER['DOCUMENT_ROOT'] . CONTEXT_NAME . '_log/');

/* 
define('SERVERNAME', "108.179.193.39");
define('USERNAME', 'tarley_zeitgeist');
define('PASSWORD', 'H@w>7%++');
define('DBNAME', 'tarley_zeitgeist');
*/


define('SERVERNAME', "localhost");
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'bd_zeitgeist');

define('ENV', 'Dev');

/* CONFIGURAÇÕES LOGENTRIES */
$LOGENTRIES_TOKEN = "0fff9a74-e2b2-40d7-965e-215f0c01e8c5";

require_once 'util/log/logentries.php';
require_once 'util/log/log.php';

Log::$log = $log;

//Log::Debug("Teste de log");