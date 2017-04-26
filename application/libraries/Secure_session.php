<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secure_session {

	public function __construct() {
		$this->sec_session_start();
	}

    public function sec_session_start() {
    	$session_name = "sec_session_id";
    	$secure = FALSE; // dev mode
    	$httponly = TRUE;

    	if(ini_set('session.use_only_cookies', 1) === FALSE) {
    		$error_msg = '<p>Could not initiate a secure session.</p>';
    		return $error_msg;
    	}

    	$cookieParams = session_get_cookie_params();
    	session_set_cookie_params(
    		$cookieParams['lifetime'],
    		$cookieParams['path'],
    		$cookieParams['domain'],
    		$secure,
    		$httponly);

    	session_name($session_name);
    	session_start();
    	session_regenerate_id(TRUE);
    	return TRUE;
    }
}