<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
		$this->load->model('login_process');
		$this->load->model(array('player_model', 'team_model', 'event_model'));
	}

	function index()
	{
		$login_status = $this->login_process->login_check();
		$data['login_status'] = $login_status;
		$data['css'] = array('event');

		$this->load->view('templates/header', $data);
		$this->load->view('event');
		$this->load->view('templates/footer');
	}

}
