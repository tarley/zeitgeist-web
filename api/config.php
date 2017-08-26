<?php

date_default_timezone_set('America/Sao_Paulo');

define('CONTEXT_NAME', '/zeitgeist-web/api/');
define('LOG_DIR', $_SERVER['DOCUMENT_ROOT'] . CONTEXT_NAME . '_log/');

define('SERVERNAME', "localhost");
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'ZeitGeistDB');

define('ENV', 'Dev');