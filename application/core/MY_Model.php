<?php

class MY_Model extends CI_Model {

	// ユーザ
	public function user($user_id)
	{
		$this->db->from('user');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		$row = $query->row_array();
		unset($row['password']);
		return $row;
	}

}
