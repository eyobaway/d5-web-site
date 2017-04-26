<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player_model extends CI_Model {

	private $table_name = "players";
	private $db_fields = array('username', 'email', 'password', 'salt', 'player', 'gamername', 'stats', 'infos');

	function __construct() {
		parent::__construct();
		$this->load->model('login_process');
	}

	public function is_owner($player_id) {
		return $this->login_process->login_check() == $player_id;
	}

	public function find_player($player_id) {
		$sql = "SELECT player_id, username FROM players WHERE player_id = ? LIMIT 1";
		$query = $this->db->query($sql, $player_id);
		if ($query) {
			$result = $query->row();
			$player_info = array(
				'player_id'  => $result->player_id,
 				'username' => $result->username);
			return $player_info;
		} else {
			return FALSE;
		}
	}

	public function find_all_players() {
		$query = $this->db->query("SELECT player_id, username FROM players");
		if ($query) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}

	/**
	* REDUNDANT -- MODIFY THE FIND_ALL_PLAYERS FUNCTION INSTEAD
	*
	* all_players_id()
	* @return array
	* The function returns an array containing all the players
	* the value with in the array will be the player ID as the key
	* and the player username as the value
	*/

	public function no_team_players_id() {
		$all_players_id = array();
		$query = $this->db->query("SELECT player_id, username FROM players WHERE team_id = 0");
		if ($query) {
			$all_players = $query->result_array();
			foreach ($all_players as $player) {
				$all_players_id[$player['player_id']] = $player['username'];
			}
			return $all_players_id;
		} else {
			return FALSE;
		}
	}

	/**
	*
	* add_player
	* @param string
	* @return bool | string
	*/
	public function add_player($username, $email, $password, $salt, $player = '', $gamername = '', $stats = '', $infos = '') {
		$sql = "INSERT INTO players (username, email, password, salt, player, gamername, stats, infos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($username, $email, $password, $salt, $player, $gamername, $stats, $infos));

		if ($query) {
			return TRUE;
		} else {
			return'<p class="error">ERR-UDBIE: There was a problem processing the request.</p>';
		}
	}

	/**
	*
	* get_player_player
	* @param int
	* @return array | string
	*/
	public function get_player_full_info($player_id) {
		// player column from the players table
		$sql = "SELECT player_id, username, email, player, gamername, stats, infos, active from players WHERE player_id = ? LIMIT 1";
		$query = $this->db->query($sql, $player_id);
		if ($query) {
			$result = $query->row();
			return $result;			
		} else {
			return FALSE;
			// return'<p class="error">There was a problem processing the request.</p>';
		}
	}

	/**
	 * checks wheather a user with the given id exists
	 *
	 * @param       int  $player_id
	 * @return      bool
	 */
	public function player_exists($player_id) {
		$sql = "SELECT player_id FROM players WHERE player_id = ? LIMIT 1";
		$query = $this->db->query($sql, $player_id);
		if ($query && $query->num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 *
	 */
	public function get_player_team($player_id) {
		$sql = "SELECT team_id FROM players WHERE player_id = ?";
		$query = $this->db->query($sql, $player_id);
		if ($query) {
			$result = $query->result_array();
			return $result[0]['team_id'];
		} else {
			return FALSE;
		}
	}

	public function is_team_admin($player_id, $team_id) {
		$sql = "SELECT team_admin FROM teams WHERE team_id = ? LIMIT 1";
		$query = $this->db->query($sql, $team_id);
		if ($query) {
			$result = $query->result_array();

			if ($result[0]['team_admin'] == $player_id) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function get_player_info($player_id) {
		// player column from the players table
		$sql = "SELECT username, email, player, gamername, stats, infos, active FROM players WHERE player_id = ? LIMIT 1";
		$query = $this->db->query($sql, $player_id);
		if ($query) {
			$result = $query->result_array();
			return array(
				'player_id' => $player_id,
				'username'  => $result[0]['username'],
				'email'		=> $result[0]['email'],
				'player'	=> $result[0]['player'],
				'gamername' => $result[0]['gamername'],
				'stats'     => $result[0]['stats'],
				'infos'		=> $result[0]['infos']
				);
		} else {
			return FALSE;
			// return'<p class="error">There was a problem processing the request.</p>';
		}
	}

	public function request_join($team_id) {
		
	}

}