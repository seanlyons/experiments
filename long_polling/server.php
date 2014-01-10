<?PHP
set_time_limit(0);
session_start();
$h = json_encode('hello');
error_log($h);
return;