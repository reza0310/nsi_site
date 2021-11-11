<?php
set_include_path(dirname(__DIR__, 2)."\\vars");
echo (str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)));
?>