<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_process extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
    	// EMAIL IS INJECTIBLE

    	// check if email is valid
    	

    	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		$error_msg = array();

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			// not a valid email
			$error_msg[] = '<p class="error">The email address you entered is not valid</p>';
			// return FALSE;
		}

		$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
		if(strlen($password) != 128)
		{
			// the hashed password should 128 characters long
			// if its not something really odd has happened
			$error_msg[] = '<p class="error">Something serious has gone wrong. Report now!</p>';
			// return FALSE;
		}

		// find the user corresponding to the given email address
		$sql = "SELECT player_id, username, password, salt FROM players WHERE email = ? LIMIT 1";
		$query = $this->db->query($sql, $email);
		if ($query) {
			if ($query->num_rows() == 1) {
				$result = $query->row();
				
				// user is found
				// hash the pass with the salt
				$password = hash('sha512', $password.$result->salt);

				// check for number of tries
				if ($this->check_brute($result->player_id) == TRUE) {
					// account locked for repeated failed login attempts
					$error_msg[] = "<p>Account is locked due to repeated failed login attempts.</p>";
					// return FALSE;
				} else {
					// check password
					if ($password == $result->password) {
						$user_browser = $this->security->xss_clean($_SERVER['HTTP_USER_AGENT']); // browser
						$player_id = preg_replace("/[^0-9]+/", "", $result->player_id);
						$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $result->username);

						// assign session variables
						$_SESSION['player_id'] = $player_id;
						$_SESSION['username'] = $username;
						$_SESSION['login_string'] = hash('sha512', $password.$user_browser);

						return TRUE; // login success
					} else {
						// wrong password input
						// add activity in database
						$sql = "INSERT INTO login_attempts (player_id, time) VALUES (?, ?)";
						$this->db->query($sql, array($result->player_id, time()));
						$error_msg[] = "<p>ERR PASS: Email/password combination is incorrect.</p>";
						// return FALSE;
					}
				}
			} else {
				// user doesnt exist
				// return FALSE;
				$error_msg[] = "<p>NO USR: Email/password combination is incorrect.</p>";
			}
		} else {
			
		}

		if (!empty($error_msg)) { 
			return $error_msg; 
		} else {
			return TRUE;
		}
    }

    protected function check_brute($player_id) {
		$now = time(); // get time
		$valid_attempts = $now - (2 * 60 * 60); // attempts are counted from past 2hrs

		$sql = "SELECT time FROM login_attempts WHERE player_id = ? AND time > '$valid_attempts'";
		$query = $this->db->query($sql, $player_id);

		if($query) {
			// if there have been more than 5 attempts
			if ($query->num_rows() > 5) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * Checks the login status
	 *
	 * returns the player_id if logged in else returns FALSE
	 * @return      mixed
	 */
	public function login_check() {
		// check if all session variables are set
		if(isset($_SESSION['player_id'], $_SESSION['username'], $_SESSION['login_string'])) {
			$player_id = $_SESSION['player_id'];
			$login_string = $_SESSION['login_string'];
			$username = $_SESSION['username'];

			// get the user-agent string of the user
			$user_browser = $_SERVER['HTTP_USER_AGENT'];

			$sql = "SELECT password, username FROM players WHERE player_id = ? LIMIT 1";
			$query = $this->db->query($sql, $player_id);
			if ($query) {
				if($query->num_rows() == 1) {
					// user exists: get vars from result
					$result = $query->row();
		
					$login_check = hash('sha512', $result->password . $user_browser);

					if($login_check == $login_string) {
						// logged in
						return array(
							'player_id' => $player_id, 
							'username'  => $username
							);
					} else {
						// not logged in
						// echo "Login string mismatch";
						return FALSE;
					}
				} else {
					// not logged in
					// echo "query returned more than one row";
					return FALSE;
				}
			} else {
				// not logged in
				// echo "query failed";
				return FALSE;
			}
		} else {
			// not logged in
			// echo "needed session vars are not set";
			return FALSE;
		} 
	}


}