<?php
$mail = $_GET["login"];
$pass = $_GET["mdp"];
set_include_path(dirname(__DIR__, 3)."\\vars");
echo(str_replace('%php2%', $pass, str_replace('%php%', $mail, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)))));
?>