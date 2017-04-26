<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
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
		// get the current status
		$login_status = $this->login_process->login_check();

		// if already logged in redirect to the players profile page
		if ($login_status) {
			redirect(str_replace("index.php/", "", base_url() . 'players/player/' . $login_status['player_id']));
		}

		// the necessary data for the views
		$data = array (
			'js'  => array('forms', 'sha512'),
			'css' => array('login'),
			'login_status' => $login_status
			);

		// is the user trying to login, i.e. is the login button clicked?
		if(isset($_POST['email']) && isset($_POST['password']))
		{
			$result = $this->login_process->login(); // try to login the user with the credentials
			if ($result === TRUE) {
				// login successful
				// further actions can take place here
				$data['success'] = '<p>Successfuly Loged In!</p>';
				$this->is_logged_in = TRUE;
			} else {
				$data['error_msg'] = $result;
			}
		}
		
		if (isset($result) && $result === TRUE) {
			echo $login_status['player_id'];
			redirect(str_replace("index.php/", "", base_url() . 'players/player/' . $login_status['player_id']));
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('login', $data);
			$this->load->view('templates/footer');
		}
	}
}
