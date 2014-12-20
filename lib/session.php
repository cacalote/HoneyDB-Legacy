<?php
class session {
	# variables

	# methods
	function initialize_session_variables() {
		$this->set_user_id();
	}

	function set_user_id($user_id=0) {
		$_SESSION['user_id'] = $user_id;
	}

	function get_user_id() {
		return $_SESSION['user_id'];
	}

	function set_sessionvar($key, $value="") {
		$_SESSION[sessionvar]->$key = $value;
	}

	function get_sessionvar($key) {
		return $_SESSION[sessionvar]->$key;
	}

	function get_sessionid() {
		return session_id();
	}

	function reset() {
		$this->set_user_id();
		$_SESSION[sessionvar] = NULL;
		session_regenerate_id(true);
	}

    function is_valid_session() {
        if(!$this->get_user_id()) {
            return false;
        } else {
            return true;
        }
    }

	# constructor
	function session() {
		if('' == session_id()) {
			session_start();
		}

		if(!isset($_SESSION['user_id'])) {
			$this->initialize_session_variables();
		}
	}
}
?>
