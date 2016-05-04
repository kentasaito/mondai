<?php

class Auth_model extends MY_Model
{
	// ユーザ登録
	public function register($array)
	{
		$row = [
			'user_name' => $array['user_name'],
			'login' => $array['login'],
			'password' => password_hash($array['password'], PASSWORD_DEFAULT),
		];
		return $this->db->insert_batch('user', [$row]);
	}

	// ユーザ情報更新
	public function update($user_id, $array)
	{
		$row = [
			'user_id' => $user_id,
			'user_name' => $array['user_name'],
			'login' => $array['login'],
		];
		if (isset($array['password']))
		{
			$row['password'] = password_hash($array['password'], PASSWORD_DEFAULT);
		}
		$return_val = $this->db->update_batch('user', [$row], 'user_id');
		if ($return_val !== 1)
		{
			return FALSE;
		}
		return $this->user($user_id);
	}

	// 登録解除
	public function unsubscribe($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
		return $this->db->affected_rows();
	}

	// 認証
	public function authenticate($array)
	{
		$this->db->from('user');
		$this->db->where('login', $array['login']);
		$query = $this->db->get();
		$row = $query->row_array();
		if (password_verify($array['password'], $row['password']) !== TRUE)
		{
			return FALSE;
		}
		return $this->user($row['user_id']);
	}

}
