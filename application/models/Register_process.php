<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_process extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function register() {
    	// echo "CONTENTS HAVE REACHED THE REGISTER FUNCTION SUCCESSFULY";

    	// an array to catch errors
    	$error_msg = array();

    	// sanitization
    	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		// optional fields
		$firstname = isset($_POST['firstname']) ? filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) : '';
		$lastname  = isset($_POST['lastname'])  ? filter_input(INPUT_POST, 'lastname',  FILTER_SANITIZE_STRING) : '';
		$gamername = isset($_POST['gamername']) ? filter_input(INPUT_POST, 'gamername', FILTER_SANITIZE_STRING) : '';
		$birthdate = isset($_POST['birthdate']) ? filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING) : '';

		// this is not a really clean way, its not as good as I thought it would be
		// maybe its best just to create dedicated columns in the players table
		$player_info = array(
			'firstname' => $firstname,
			'lastname'  => $lastname,
			'birthdate' => $birthdate);

		$player = serialize($player_info);

		///////

		// server side validations --- incase a sob thought he fooled the JS validations
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// not a valid email
			$error_msg[] = '<p class="error">The email address you entered is not valid</p>';
			return $error_msg;
		}

		$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
		if(strlen($password) != 128) {
			// the hashed password should 128 characters long
			// if its not something really odd has happened
			$error_msg[] = '<p class="error">Something serious has gone wrong. Report now!</p>';
			return $error_msg;
		}
		// end of server side validations


		// check existing email
		$sql = "SELECT player_id FROM players WHERE email = ? LIMIT 1";
		$query = $this->db->query($sql, $email);
		if ($query) {
			if ($query->num_rows() == 1) { // you already have an account smartass
				$error_msg[] = '<p class="error">A player with this email address already exists.</p>';
			} else {
				// check existing username
				$sql = "SELECT player_id FROM players WHERE username = ? LIMIT 1";
				$query = $this->db->query($sql, $username);
				if ($query) {
					if ($query->num_rows() == 1) { // unfortunately that username belongs to another respected player
						$error_msg[] = '<p class="error">The username is already taken. Please try again!</p>';
					}
				} else {
					// nothing should go wrong really...but who knows
					$error_msg[] = '<p class="error">ERR-USRNMV: There was a problem processing the request.</p>';
				}
			}
		} else {
			// nothing should go wrong really...but who knows
			$error_msg[] = '<p class="error">ERR-EMLV: There was a problem processing the request.</p>';
		}

		// error sending
		if (!empty($error_msg)) {
			return $error_msg;
		} else {
			// no errors
			// continue with registration

			// generate a random salt
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

			// create a salted-hashed password (h[p+s]) ready for database insertion
			$password = hash('sha512', $password . $random_salt);

			// everything checks out...well I hope it does
			// so lets add the player to the database

			// TODO: create a funtion that adds a player in the player_model
			$result = $this->player_model->add_player($username, $email, $password, $random_salt, $player, $gamername);

			// $sql = "INSERT INTO players (username, email, password, salt, player, gamername) VALUES (?, ?, ?, ?, ?, ?)";
			// $query = $this->db->query($sql, array($username, $email, $password, $random_salt, $player, $gamername));
			// if ($query) {
			// 	// pass, congrats prick, you are now a memeber
			// 	return TRUE;
			// } else {
			// 	// nothing should go wrong really...but who knows ...
			// 	$error_msg[] = '<p class="error">ERR-UDBIE: There was a problem processing the request.</p>';
			// 	return $error_msg;
			// }
			if ($result === TRUE) {
				$this->send_activation_link($email);
				return TRUE;
			} else {
				$error_msg[] = $result;
				return $error_msg;
			}
		}
	}

	protected function send_activation_link($email) {
		// this function will send an activation link to the user
		// the link will only be valid for 24hrs
		// account will be terminated if not activated with in 7 days

		// STEP 1: GENERATE A RANDOM KEY
		$random_key = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
		
		$to        = $email;
		$subject   = 'Activate your DGC account';

		$headers  = 'From: no-reply@d5gamecon.com\r\n';
		$headers .= 'MIME-Version: 1.0r\r\n';
		$headers .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';

		$message  = '<html><body>';



	}

}