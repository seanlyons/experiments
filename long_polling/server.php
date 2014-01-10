<?PHP
sleep(40);
$h = json_encode('hello');
error_log($h);
echo json_encode(array('boop' => date('r')));
return;