<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	// public function is_owner($user_id) {
	// 	return $this->login_process->login_check() == $user_id;
	// }

	public function find($fields, $table_name, $id) {
		if (!isset($fields OR $table_name OR $id)) { return FALSE; }

		$sql = "SELECT ";
		foreach ($fields as $field) {
			if (array_search($field, $fields) == count($fields) - 1) {
				$sql .= $field . " ";
			} else {
				$sql .= $field . ", ";
			}
		$sql .= "FROM " . $table_name . " WHERE id = ? LIMIT 1"; 
		}
		// $sql .= user_id, username FROM users WHERE user_id = ? LIMIT 1";
		$query = $this->db->query($sql, $user_id);
		if ($query) {
			$result = $query->row();
			$user_info = array(
				'user_id'  => $result->user_id,
 				'username' => $result->username);
			return $user_info;
		} else {
			return FALSE;
		}
	}

	public function find_all_users() {
		$query = $this->db->query("SELECT user_id, username FROM users");
		if ($query) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}

}