<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
		$this->load->model('login_process');
		$this->load->model('player_model');
	}

	public function index()
	{
		$login_status = $this->login_process->login_check();

		$data['login_status'] = $login_status;
		$data['css'] = array('unslider', 'unslider-dots');
		$data['js'] = array('unslider-min');

		if ($login_status) {
			$data['player_info'] = $this->player_model->find_player($this->security->xss_clean($_SESSION['player_id']));
		}
		$this->load->view('templates/header_home', $data);
		$this->load->view('home', $data);
		$this->load->view('templates/footer');
	}

	public function sponsor()
	{
		// status checks //
		$login_status = $this->login_process->login_check(); // logged in or not
		//

		// necessary data for the page //
		$data = array (
			'js'  => array(), // javascripts
			'css' => array(), // pages specific stylesheets
			'login_status' => $login_status);
		//				//


		$this->load->view('templates/header', $data);
		$this->load->view('templates/footer');
	}

	public function about()
	{
		// status checks //
		$login_status = $this->login_process->login_check(); // logged in or not
		//

		// necessary data for the page //
		$data = array (
			'js'  => array(), // javascripts
			'css' => array(), // pages specific stylesheets
			'login_status' => $login_status);
		//				//


		$this->load->view('templates/header', $data);
		$this->load->view('templates/footer');
	}
}
