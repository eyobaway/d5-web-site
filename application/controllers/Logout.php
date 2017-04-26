<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
	}

	public function index() {
		if(isset($_SESSION['player_id'])) {
			// $this->secure_session->sec_session_start();
			$_SESSION = array(); // unset all session variables
			// $params = session_get_cookie_params(); // get session paramaters

			// // delete the actual cookie
			// setcookie(session_name(), '', time() - 42000,
			// 	$params['path'],
			// 	$params['domain'],
			// 	$params['secure'],
			// 	$params['httponly']);

			// destroy session
			session_destroy();
		}

		redirect(base_url());
	}
}
