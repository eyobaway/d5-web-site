<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
{

	public function __construct() 
	{

		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
		$this->load->model('login_process');
	}

	public function index()
	{
		$login_status = $this->login_process->login_check();

		// check if a player is already logged in
		if ($login_status) {
			redirect(str_replace("index.php/", "", base_url() . 'players/player/' . $login_status));
		}

		// necessary js/css for the register page
		$data = array (
			'js'  => array('forms', 'sha512'),
			'css' => array('register'),
			'login_status' => $login_status);

		// load the main register functions
		$this->load->model('register_process');
		$this->load->model('player_model');

		if(isset($_POST['username'], $_POST['email'], $_POST['p']))
		{
			$result = $this->register_process->register(); // try to register the player
			// $data['error_msg'] = $this->register_process->register();
			if ($result === TRUE) {
				// player insertion compelted successfully
			} else {
				$data['error_msg'] = $result;
			}
		}

		// views
		$this->load->view('templates/header', $data);
		if (isset($result)) {
			if ($result === TRUE) {
				$this->load->view('templates/register_success');
			} else {
				$this->load->view('register');
			}
		} else {
			$this->load->view('register');
		}
		$this->load->view('templates/footer');
	}
}
