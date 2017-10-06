<?php

date_default_timezone_set('America/Sao_Paulo');

define('CONTEXT_NAME', '/zeitgeist-web/api/');
define('LOG_DIR', $_SERVER['DOCUMENT_ROOT'] . CONTEXT_NAME . '_log/');

define('SERVERNAME', "localhost");
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'BD_ZEITGEIST');

define('ENV', 'Dev');

/* CONFIGURAÇÕES LOGENTRIES */
$LOGENTRIES_TOKEN = "0fff9a74-e2b2-40d7-965e-215f0c01e8c5";

require_once ABSPATH . '/api/util/log/logentries.php';
require_once ABSPATH . '/api/util/log/log.php';

Log::$log = $log;

Log::Debug("Teste de log");