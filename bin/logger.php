<?php
$s = !isset($_POST['s']) ? $_POST['s'] = '' : trim($_POST['s']); // secret

$authenticated = false;
$result        = array('status'=>'fail');

if('yes' == strtolower($LOGGER_ENABLE)) {
	// ip filter check
	$ipArray = array();

	if(strlen(trim($LOGGER_FILTER))) {
		$ipArray = explode(',', $LOGGER_FILTER);
	}

	if(count($ipArray)) {
		if(!in_array($_SERVER['REMOTE_ADDR'], $ipArray)) {
			// let there be fail
			$result['status'] = 'Access Denied';
			response($result);
			exit();
		}
	}

	// auth secret key
	if(strlen($LOGGER_SECRET)) {
		if($_POST['s'] == $LOGGER_SECRET) {
			$authenticated = true;
		} else {
			// let there be fail
			$result['status'] = 'Invalid Key: "' . $_POST['s'] . '"';
			response($result);
			exit();
		}
	} else {
		// secret cannot be empty
		// let there be fail
		$result['status'] = 'Empty Key';
		response($result);
		exit();
	}

	if($authenticated) {
		$parameterArray = array($_POST['date'], $_POST['time'], $_POST['date_time'], $_POST['millisecond'], $_POST['event'], $_POST['local_host'], $_POST['local_port'], str_replace(']', '', str_replace('[', '', $_POST['service'])), $_POST['remote_host'], $_POST['remote_port'], $_POST['data'], $_POST['bytes'], $_POST['data_hash']);

		$sql = "INSERT INTO honeypy (date, time, date_time, millisecond, event, local_host, local_port, service, remote_host, remote_port";

		if('CONNECT' != $_POST['event']) {
			$sql .= ", data, bytes, data_hash)";
		} else {
			$sql .= ")";
		}

		$sql .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?";

		if('CONNECT' != $_POST['event']) {
			$sql .= ", ?, ?, ?);";
		} else {
			$sql .= ")";
		}

		if(false === $db->Execute($sql, $parameterArray)) {
			// let there be fail
			$result['status'] = 'Error ' . $db->ErrorMsg();
			response($result . $sql);
        	} else {
			// let there be great success
			$result['status'] = 'Success';
			response($result);
		}
	}
} else {
	// let there be fail
	$result['status'] = 'Disabled';
	response($result);
}

function response($r) {
	header("Content-type: text/plain");
	echo json_encode($r);
}
?>
