<?php
set_include_path(dirname(__DIR__, 1)."\\vars");
echo (str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)));
?>