<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Team_model extends CI_Model 
{

	/**
	*
	* 
	*/

	function __construct() 
	{
		parent::__construct();
	}

	public function new_team() 
	{
		// get required data such as team name and stuff
		$team_name;
		$team_game;
		$team_members = array(); // from $_POST['sel1'] to $_POST['sel8']
		$team_info;
		$error_msg = [];

		// team name stuff
		if (isset($_POST['teamname'])) { 
			if (trim($_POST['teamname']) == "") {
				$error_msg[] = "You need a team name genius.";
				return $error_msg;
			}
			$team_name = $this->security->xss_clean(trim($_POST['teamname']));

			// if team name exists, prompt for a change
			$sql = "SELECT team_id FROM teams WHERE team_name = ?";
			$query = $this->db->query($sql, $team_name);
			if ($query->num_rows() == 1) {
				$error_msg[] = "Team name is already taken.";
				return $error_msg;
			}

		}

		// team desc stuff
		if (isset($_POST['teamdesc'])) { $team_info = $this->security->xss_clean(trim($_POST['teamdesc'])); }

		// team game stuff
		if (isset($_POST['teamgame'])) { $team_game = $this->security->xss_clean(trim($_POST['teamgame'])); }

		// the admin
		$team_members[] = $team_admin = $_SESSION['player_id'];

		// mastekakel the members registering
		if (isset($_POST['sel1']) && $_POST['sel1'] != 0) { $team_members[] = $_POST['sel1']; }
		if (isset($_POST['sel2']) && $_POST['sel2'] != 0) { $team_members[] = $_POST['sel2']; }
		if (isset($_POST['sel3']) && $_POST['sel3'] != 0) { $team_members[] = $_POST['sel3']; }
		if (isset($_POST['sel5']) && $_POST['sel5'] != 0) { $team_members[] = $_POST['sel5']; }
		if (isset($_POST['sel6']) && $_POST['sel6'] != 0) { $team_members[] = $_POST['sel6']; }
		if (isset($_POST['sel7']) && $_POST['sel7'] != 0) { $team_members[] = $_POST['sel7']; }
		if (isset($_POST['sel8']) && $_POST['sel8'] != 0) { $team_members[] = $_POST['sel8']; }

		// the team admin will be the one who created the team
		// team creation can only be done while logged in so
		// the user_id stored in the session will be used to set
		// the admin
		$team_admin = $_SESSION['player_id'];

		// requirements

		// 1. A team must have at least 5 members --- might be ammended
		// if (count($team_members) < 5)
		// {
		// 	// not enough members
		// 	$error_msg[] = "Not enough players. Select more!";
		// 	return $error_msg;
		// }

		// 2. must have a valid team name (JS should take care of this but should be here for maximum safety)

		// 3. $team_game will be selected from a list of given choices

		if (empty($error_msg)) {
			// create the team
			$sql = "INSERT INTO teams (team_name, team_game, team_members, team_info, team_admin, team_count) VALUES (?, ?, ?, ?, ?, ?)";
			$members = serialize($team_members);
			if ($this->db->query($sql, array($team_name, $team_game, $members, $team_info, $team_admin, count($team_members))))
			{
				// get the inserted row id
				$team_id = $this->db->insert_id();
				// if the team insertion successed, modify the team field in the player table
				foreach ($team_members as $team_member) {
					$sql = "UPDATE players SET team_id = ? WHERE player_id = ?";
					if ($this->db->query($sql, array($team_id, $team_member))) {
						// player info updated successfully
					} else {
						$error_msg[] = "Couldn't add player " . $team_member . "to the team.";
					}
				}

				if (!empty($error_msg)) {
					// do somthing about it
					// probably a player isn't added
					// carry this error to the team page and display it there
				} else {
					redirect('teams/team/' . $team_id);
				}

				return TRUE;
			}
			else
			{
				$error_msg[] = "Error occured.";
				return $error_msg;
			}
			// add player relations in the player table
		}
	}

	public function remove_team($team_id)
	{
		$message = [];

		$sql = "DELETE FROM teams WHERE team_id = ? LIMIT 1";
		if ($this->db->query($sql, $team_id))
		{
			// remove the relations in the players table
			$team_members = $this->get_team_members($team_id);
			foreach ($team_members as $member) {
				$sql = "UPDATE players SET team_id = 0 WHERE player_id = ?";
				if ($this->db->query($sql, $member)) {
					// update success
				} else {
					$message[] = "Couldn't remove player " . $player_id;
				}
			}
		}
		else
		{
			$message[] = "Couldn't remove team!";
		}

		if (empty($message)) {
			$message[] = "The team was removed successfully!";
		}
		
		$_SESSION['message'] = $message;
		redirect('players/player/' . $_SESSION['player_id']);
	}

	public function add_member($player_id, $team_info)
	{
		if ($team_info['team_count'] < 9) {
			// 1. update the players table (team_id)
			// 2. update the team_members
			// 3. update the team_count
			// 4. remove the player request

			$sql = "UPDATE players SET team_id = ? WHERE player_id = ?";
			if ($this->db->query($sql, array($team_info['team_id'], $player_id))) {
				// step 1 is sucess
				$team_members = $team_info['team_members'];
				$team_members[] = $player_id;
				$team_members = serialize($team_members);
				$sql = "UPDATE teams SET team_members = ? WHERE team_id = ?";
				if ($this->db->query($sql, array($team_members, $team_info['team_id']))) {
					// step 2 is a success
					$sql = "UPDATE teams SET team_count = team_count + 1 WHERE team_id = ?";
					if ($this->db->query($sql, $team_info['team_id'])) {
						// step 3 is a success
						// removing the request
						$requests = unserialize($team_info['requests']);
						$key = array_search($player_id, $requests);
						if ($key != -1) {
							unset($requests[$key]);
						}
						$requests = serialize($requests);
						$this->db->query("UPDATE teams SET requests = ? WHERE team_id = ?", array($requests, $team_info['team_id']));
						return TRUE;
					} else {
						return FALSE;
					}
				} else {
					return FLASE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function remove_member($player_id, $team_info)
	{
		
		// 1. remove the relation from the player table
		// 2. decerement the team_count in the team table

		$sql = "UPDATE players SET team_id = 0 WHERE player_id = ?";
		if ($this->db->query($sql, $player_id)) {
			// success - player removed from team
			$sql = "UPDATE teams SET team_count = team_count - 1 WHERE team_id = ?";
			if ($this->db->query($sql, $team_info['team_id'])) {
				// success
				$team_members = $team_info['team_members'];
				
				unset($team_members[array_search($player_id, $team_members)]);

				$team_members = serialize($team_members);
				$sql = "UPDATE teams SET team_members = ? WHERE team_id = ?";
				if ($this->db->query($sql, array($team_members, $team_info['team_id']))) {
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			// fail
			return FLASE;
		}

	}

	/**
	 * checks wheather a team with the given id exists
	 *
	 * @param       int  $team_id
	 * @return      bool
	 */
	public function team_exists($team_id) {
		$sql = "SELECT team_id FROM teams WHERE team_id = ? LIMIT 1";
		$query = $this->db->query($sql, $team_id);
		if ($query && $query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_team_info($team_id) {
		$sql = "SELECT team_name, team_game, team_members, team_count, team_admin, requests FROM teams WHERE team_id = ?";
		$query = $this->db->query($sql, $team_id);
		if ($query) {
			$result = $query->result_array();
			return array('team_name' => $result[0]['team_name'], 'team_game' => $result[0]['team_game'], 'team_members' => $result[0]['team_members'], 'team_count' => $result[0]['team_count'], 'team_admin' => $result[0]['team_admin'], 'requests' => $result[0]['requests']);
		}
	}

	public function get_team_members($team_id) {
		$sql = "SELECT player_id FROM players WHERE team_id = ?";
		$query = $this->db->query($sql, $team_id);
		if ($query) {
			return $query->result_array();
		}
	}

	public function get_teams_with_slots() {
		$query = $this->db->query("SELECT team_id, team_name, team_game, team_count FROM teams"); //WHERE team_count < 5");

		if ($query) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}

	public function send_join_request($team_id, $player_id) {

		$query = $this->db->query("SELECT requests FROM teams WHERE team_id = ?", $team_id);

		if ($query) {

			$result = $query->result_array()[0]['requests'];
			if ($result != 0) {

				$current_requests = unserialize($result);

				// check if the player already sent a request
				// dont add if already requested
				if (array_search($player_id, $current_requests)) {
					return FALSE;
				} else {
					$current_requests[] = $player_id;

					$to_db = serialize($current_requests);

					$sql = "UPDATE teams SET requests = ? WHERE team_id = ?";
					$query = $this->db->query($sql, array($to_db, $team_id));

					if ($query) {
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	public function remove_request($player_id, $team_id) {
		$query = $this->db->query('SELECT requests FROM teams WHERE team_id = ?', $team_id);
		if ($query) {
			$result = $query->result_array()[0]['requests'];
			if ($result) {
				$current_requests = unserialize($result);

				$key = array_search($player_id, $current_requests);
				if ($key != -1) {
					unset($current_requests[$key]);

					$to_db = serialize($current_requests);
					$sql = "UPDATE teams SET requests = ? WHERE team_id = ?";
					$query = $this->db->query($sql, array($to_db, $team_id));

					if ($query) {
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

}

