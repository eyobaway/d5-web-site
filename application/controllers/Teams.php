<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('secure_session');
		$this->load->model('login_process');
		$this->load->model(array('player_model', 'team_model'));
	}

	public function index()
	{

		$login_status = $this->login_process->login_check();
		$data['login_status'] = $login_status;

		// load views
		$this->load->view('templates/header', $data);
		//$this->load->view('templates/header');
		$this->load->view('templates/footer');
	}

	public function create()
	{
		$login_status = $this->login_process->login_check();
		if (!$login_status) {
			redirect('login');
		}
		// we need to find all players and populate 
		// the select field in the new team page
		$all_players_id = $this->player_model->no_team_players_id();

		// remove the creators ID from the returned list
		unset($all_players_id[$_SESSION['player_id']]);

		// does player already have a team?
		if ($this->player_model->get_player_team($_SESSION['player_id'])) {
			redirect('players/player/' . $_SESSION['player_id']);
		}

		$error = [];

		if (isset($_POST['register'])) {
			$result = $this->team_model->new_team();
			if ($result === TRUE) {
				// take me to the team page
				echo "TEAM CREATED SUCCESSFULLY";
			} else {
				echo "TEAM CREATTION FAILED";
				$error = $result;
			}
		}

		
		$data = array (
			'js'  => array('forms', 'sha512'),
			'css' => array('register'),
			'login_status' => $login_status,
			'all_players_id' => $all_players_id,
			'error_msg' => $error
			);

		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('new_team', $data);
		$this->load->view('templates/footer');
	}

	public function team($team_id, $action = NULL) {

		$error_msg = [];

		// pre-page load checks
		if ($team_id == "" || !is_numeric($team_id)) {
			// if no team_id is provided or its an invalid format
			// redirect to the home page
			// the str_replace is to remove the index.php from URI
			redirect(str_replace('index.php/', '', base_url())); 
		}

		// does a team with the given id exist
		if (!$this->team_model->team_exists($team_id)) {
			redirect(str_replace('index.php/', '', base_url())); 
		}
		// end of pre page load checks

		// status checks //
		$login_status = $this->login_process->login_check(); // logged in or not
		$team_info = $this->team_model->get_team_info($team_id);
		//

		$requests = unserialize($team_info['requests']);

		if (is_array($requests) && (count($requests) > 0)) {
			foreach ($requests as $request) {
				$team_info['join_requests'][$request] = $this->player_model->get_player_info($request)['username']; 
			}
		}
		

		// $team_info['requests'] = unserialize($team_info['requests']);
		$team_info['team_members'] = unserialize($team_info['team_members']);
		//			//

		// admin viewing it? //
		$admin = FALSE;
		if ($team_info['team_admin'] == $login_status['player_id']) {
			$admin = TRUE;
		}

		$team_info['team_id'] = $team_id;

		// is any action set by the user

		// delete the team!
		if (($action == "delete") && $admin) {
			// proceed with the delete of team
			$this->team_model->remove_team($team_id);
		} else if ($action == "delete") {
			//$error_msg[] = "Insufficinet privilages for the requested operation!";
			redirect('login');
		} 

		// leave and disunify the team -- team_admin only
		if (($action == "disunify") && $admin) {
			foreach ($team_info['team_members'] as $member) {
				if (!$this->team_model->remove_member($member, $team_info)) {
					echo "Error occured while removing player " . $player;
				}
			}

			$this->team_model->remove_team($team_id);
		} 

		// leave the team!
		if (($action == "leave") && $login_status) {
			if ($this->team_model->remove_member($login_status['player_id'], $team_info)) {
				redirect('login');
			} else {
				redirect('home');
			}
		} 

		// request the team?
		if (($action == "request") && $login_status) {
			// $this->team_model->add_member($login_status['player_id'], $team_info)
			
			if ($this->team_model->send_join_request($team_info['team_id'], $login_status['player_id'])) {
				$_SESSION['message'] = array(
					'type' => 'success',
					'content' => "Request sent successfully.");
				redirect('teams/team/' . $team_info['team_id']);
				//redirect('login');
			} else {
				$_SESSION['message'] = array(
					'type' => 'error',
					'content' => "Join request failed.");
				redirect('teams/team/' . $team_info['team_id']);
			}
		}

		// join request add
		if (($action == "join") && $admin && (isset($_GET['id']))) {
			$player_id = $_GET['id'];
			unset($_GET['id']);

			// is the player already in another team?
			if  ($this->player_model->get_player_team($player_id) != 0) {
				// already in a team
				// remove the request
				$this->team_model->remove_request($player_id, $team_info['team_id']);

				// set a message for the page
				$_SESSION['message'] = "Player is already in a team";
				redirect('teams/team' . $team_info['team_id']);
			}

			if ($this->team_model->add_member($_GET['id'], $team_info)) {
				// remove the request
				redirect("teams/team/" . $team_info['team_id']);
			} else {
				redirect('home');
			}
		} 

		// remove a player
		if (($action == "remove") && (isset($_GET['id'])) && $admin ) {
			$player_id = $_GET['id'];
			unset($_GET['id']);
			if ($this->team_model->remove_member($_GET['id'], $team_info)) {
				// remove the request
				redirect("teams/team/" . $team_info['team_id']);
			} else {
				redirect('home');
			}
		} 

		// necessary data for the page //
		$data = array (
			'js'  => array(), // javascripts
			'css' => array('team'), // pages specific stylesheets
			'login_status' => $login_status,
			'team_info' => $team_info,
			'admin' => $admin,
			'error_msg' => $error_msg);
		//				//
		// build the view //
		$this->load->view('templates/header', $data);
		$this->load->view('team', $data);
		$this->load->view('templates/footer');
		//

	}

	public function join() {

		// status checks //
		$login_status = $this->login_process->login_check(); // logged in or not
		//
		if ($login_status) {
			if ($this->player_model->get_player_team($login_status['player_id']) != 0) {
				redirect('login');
			} // get the players team
		}
		

		// teams with free spots //
		$teams_list = $this->team_model->get_teams_with_slots();

		// necessary data for the page //
		$data = array (
			'js'  => array(), // javascripts
			'css' => array('team'), // pages specific stylesheets
			'login_status' => $login_status,
			'teams_list' => $teams_list);
		//				//


		$this->load->view('templates/header', $data);
		$this->load->view('join_team', $data);
		$this->load->view('templates/footer');
	}

}