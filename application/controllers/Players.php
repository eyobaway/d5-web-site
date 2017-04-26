<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Players extends CI_Controller 
{

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
		$this->load->model(array('player_model', 'team_model', 'login_process'));
	}

	public function index() {
		// players page
		/*
			IDEAS
			- Display the players list
			- top player
			- ....
		*/

		$login_status = $this->login_process->login_check();

		$data['login_status'] = $login_status;
		$data['players'] = $this->player_model->find_all_players();

		$this->load->view('templates/header', $data);
		$this->load->view('players/player_index', $data);
		$this->load->view('templates/footer');
	}

	// opens a player specific page based on the provided player_id
	public function player($player_id = "") {

		// pre-page load checks
		if ($player_id == "" || !is_numeric($player_id)) {
			// if no player_id is provided or its an invalid format
			// redirect to the home page
			// the str_replace is to remove the index.php from URI
			redirect(str_replace('index.php/', '', base_url())); 
		}

		// does a player with the given id exist
		if (!$this->player_model->player_exists($player_id)) {
			redirect(str_replace('index.php/', '', base_url())); 
		}
		// end of pre page load checks


		// state checks
		$login_status = $this->login_process->login_check(); // logged in or not
		$team_id = $this->player_model->get_player_team($player_id); // get the players team
		
		if ($team_id != 0) {
			$team_name = $this->team_model->get_team_info($team_id)['team_name'];
			// check if player is team admin
			$team_admin = $this->player_model->is_team_admin($login_status['player_id'], $team_id);
			$team_admin_id = $this->team_model->get_team_info($team_id)['team_admin'];
		} else {
			$team_name = '';
			$team_admin = FALSE;
			$team_admin_id = FALSE;
		}



		if ($login_status['player_id'] === $player_id) {
			// player is looking at his own page
			$admin = TRUE;
		} else {
			$admin = FALSE;
		}
		// end of state checks


		// misc data //
		// end of stuff //


		// set all the data necessary for views
		$data = array (
			'js'  => array(), // javascripts
			'css' => array('player'), // pages specific stylesheets
			'player_info' => $this->player_model->find_player($player_id), // the player info such as playername
			'player' => $this->player_model->get_player_full_info($player_id),
			'login_status' => $login_status,
			'team_id' => $team_id,
			'team_admin' => $team_admin,
			'team_admin_id' => $team_admin_id,
			'team_name' => $team_name,
			'admin' => $admin);

		$this->load->view('templates/header', $data);
		$this->load->view('player', $data);
		$this->load->view('templates/footer');
	}

}