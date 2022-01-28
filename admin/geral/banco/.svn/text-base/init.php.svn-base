<?php

error_reporting(0);
@ini_set('display_errors', '0');
@ini_set('register_globals', '0');
set_time_limit(0);

if (!extension_loaded('mysql')) {
    echo( "Nao esta habilitada a dll Mysql" );
    exit;   
}

if(!file_exists("banco/config.php")) {
    echo "Nao foi localizado o arquivo <b>config.php</b>";
    exit;
} else {
    require "banco/config.php";
}

if (!defined('SERVIDOR') or !defined('USUARIO') or !defined('SENHA')){
    echo "O arquivo <b>config.php</b> nao esta correto<br />";
    echo "Crie o <b>config.php</b> dessa maneira:<br />";
    echo highlight_string("<?php
define(\"SERVIDOR\", \"localhost\");
define(\"USUARIO\", \"coloque_seu_usuario\");
define(\"SENHA\", \"coloque_sua_senha\");
?>", 1);
exit;
}

?>