<?PHP
set_time_limit(0);
session_start();
init();
return;

function init() {
    assignSessionId();

    //if data exists in MySQL->pushQueue($sid), return it
    //else sleep(2)
    //call init()
    
    while(TRUE) {
        $response_file = file(__dir__ . '/response.txt', FILE_IGNORE_NEW_LINES);
        error_log('response_file:' . json_encode($response_file));
        error_log('session:' . json_encode($_SESSION));
        if ($response_file !== FALSE) {
            $r = '';
            foreach ($response_file as $k => $v) {
                $r .= $v;
            }
            //They've already seen this message: skip it.
            if ($_SESSION['last_message'] == md5($r)) {
                sleep(5);
                break;
            }
            //Save this as the last message they saw
            $_SESSION['last_message'] = md5($r);
            //Communicate to the client what the message value is.
            $r .= ' & last_message = ' . md5($r);
            $r = json_encode($r);
            error_log($r);
            echo $r;
            return $r;
        } else {
            sleep(5);
        }
    }
}

function assignSessionId() {
    if (!isset($_SESSION['id'])) {
        $_SESSION['id'] = uniqid();
        $_SESSION['last_message'] = '';
    }
}