<?PHP
session_start();
// session_destroy();
// session_start();

error_log('starting!');

init();

for($i = 0; $i < 60 /*ten minutes*/; $i++) {
	$highest = 0;
	
	error_log('sleeping...' . $_SESSION['id']);
	error_log('last line seen: ' . $_SESSION['last_line_seen']);
	
	// error_log('microtime = ' . microtime());
    if ($i > 0) {
		sleep(10);
	}
    $response = array();
	$last_reject = '';
	
	error_log('response size = ' . sizeof($response));
	$comm = file(__dir__ . '/response.txt', FILE_IGNORE_NEW_LINES);    
    foreach ($comm as $l_num => $l_val) {
		$highest = $l_num;
        if ($l_num > $_SESSION['last_line_seen']) {
            $response[] = $l_val;
			error_log("ACCEPT: #$l_num => $l_val");
        } else {
			$last_reject = "REJECT: #$l_num => $l_val";
		}
    }
	if ($last_reject) {
		error_log($last_reject);
	}
	error_log("highest : $highest ; i : $i");
	
    if (!empty($response)) {
		//Override to make all clients stop pinging.
		$kill9 = file(__dir__ . '/kill9.txt', FILE_IGNORE_NEW_LINES);
		if ($kill9) {
			$response['kill9'] = TRUE;
		}
		
		
        $_SESSION['last_line_seen'] = $highest;
        $r = json_encode($response);
		error_log('responses is set, echoing ' . $r);
        echo $r;
        exit;
    }
}
echo json_encode('timeout');
exit;

function init() {
    if (!isset($_SESSION['last_line_seen'])) {
        $_SESSION['last_line_seen'] = 0;
		$_SESSION['id'] = uniqid();
    }
}


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// set_time_limit(0);
// session_start();
// init();
// return;

// function init() {
    // assignSessionId();

    // //if data exists in MySQL->pushQueue($sid), return it
    // //else sleep(2)
    // //call init()
    
    // while(TRUE) {
        // $response_file = file(__dir__ . '/response.txt', FILE_IGNORE_NEW_LINES);
        // error_log('response_file:' . json_encode($response_file));
        // error_log('session:' . json_encode($_SESSION));
        // if ($response_file !== FALSE) {
            // $r = '';
            // foreach ($response_file as $k => $v) {
                // $r .= $v;
            // }
            // //They've already seen this message: skip it.
            // if ($_SESSION['last_message'] == md5($r)) {
                // sleep(5);
                // break;
            // }
            // //Save this as the last message they saw
            // $_SESSION['last_message'] = md5($r);
            // //Communicate to the client what the message value is.
            // $r .= ' & last_message = ' . md5($r);
            // $r = json_encode($r);
            // error_log($r);
            // echo $r;
            // return $r;
        // } else {
            // sleep(5);
        // }
    // }
// }

// function assignSessionId() {
    // if (!isset($_SESSION['id'])) {
        // $_SESSION['id'] = uniqid();
        // $_SESSION['last_message'] = '';
    // }
// }