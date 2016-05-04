<?php

class Mypage_model extends CI_Model
{
	// 解答者一覧
	public function kaitosha_ichiran()
	{
		$subquery = $this->kiroku_shukei([], 'kaitosha_id');
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('kaito_su');
		$this->db->from('user');
		$this->db->join("({$subquery}) AS kiroku_shukei", 'user.user_id = kiroku_shukei.kiroku_kaitosha_id', 'left');
		$this->db->where('`kaito_su` IS NOT NULL', NULL, FALSE);
		return $this->result($this->db->get());
	}

	// 出題者一覧
	public function shutsudaisha_ichiran()
	{
		$subquery = $this->mondai_shukei([]);
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('repository');
		$this->db->select('mondai_su');
		$this->db->select('setsumon_su');
		$this->db->select('kaito_su');
		$this->db->from('user');
		$this->db->join("({$subquery}) AS mondai_shukei", 'user.user_id = mondai_shukei.mondai_shutsudaisha_id', 'left');
		$this->db->where('`mondai_su` IS NOT NULL', NULL, FALSE);
		return $this->result($this->db->get());
	}

	// 問題一覧
	public function mondai_ichiran($where = [])
	{
		$subquery = $this->setsumon_shukei($where);
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('mondai_id');
		$this->db->select('mondaimei');
		$this->db->select('setsumon_su');
		$this->db->select('kaito_su');
		$this->db->select('seikai_ritsu');
		$this->db->from('mondai');
		$this->db->join('user', 'user.user_id = mondai.shutsudaisha_id', 'left');
		$this->db->join("({$subquery}) AS setsumon_shukei", 'mondai.mondai_id = setsumon_shukei.setsumon_mondai_id', 'left');
		if (isset($where['kaitosha_id']))
		{
			$this->db->where('`kaito_su` IS NOT NULL', NULL, FALSE);
		}
		if (isset($where['shutsudaisha_id']))
		{
			$this->db->where('shutsudaisha_id', $where['shutsudaisha_id']);
		}
		return $this->result($this->db->get());
	}

	// 設問一覧
	public function setsumon_ichiran($where = [], $order_by = [], $limit = NULL)
	{
		$subquery = $this->kiroku_shukei($where, 'setsumon_id');
		$this->db->select('setsumon_id');
		$this->db->select('mondai_setsumon_id');
		$this->db->select('mondaibun');
		$this->db->select('seikaito');
		$this->db->select('kaito_su');
		$this->db->from('setsumon');
		$this->db->join("({$subquery}) AS kiroku_shukei", 'setsumon.setsumon_id = kiroku_shukei.kiroku_setsumon_id', 'left');
		if (isset($where['mondai_id']))
		{
			$this->db->select('seikai_ritsu');
			$this->db->select('millisec');
			$this->db->select('gokaito');
			$this->db->where('mondai_id', $where['mondai_id']);
		}
		foreach ($order_by as $value)
		{
			$this->db->order_by($value, NULL, FALSE);
		}
		if (is_numeric($limit))
		{
			$this->db->limit($limit);
		}
		return $this->result($this->db->get());
	}

	// 解答者
	public function kaitosha($kaitosha_id)
	{
		$subquery = $this->kiroku_shukei(['kaitosha_id' => $kaitosha_id], 'kaitosha_id');
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('kaito_su');
		$this->db->from('user');
		$this->db->join("({$subquery}) AS kiroku_shukei", 'user.user_id = kiroku_shukei.kiroku_kaitosha_id', 'left');
		$this->db->where('user_id', $kaitosha_id);
		return $this->row($this->db->get());
	}

	// 出題者
	public function shutsudaisha($shutsudaisha_id)
	{
		$subquery = $this->mondai_shukei(['shutsudaisha_id' => $shutsudaisha_id]);
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('repository');
		$this->db->select('mondai_su');
		$this->db->select('setsumon_su');
		$this->db->select('kaito_su');
		$this->db->from('user');
		$this->db->join("({$subquery}) AS mondai_shukei", 'user.user_id = mondai_shukei.mondai_shutsudaisha_id', 'left');
		$this->db->where('user_id', $shutsudaisha_id);
		return $this->row($this->db->get());
	}

	// 問題
	public function mondai($where = [])
	{
		$subquery = $this->setsumon_shukei($where);
		$this->db->select('user_id');
		$this->db->select('user_name');
		$this->db->select('mondai_id');
		$this->db->select('mondaimei');
		$this->db->select('setsumon_su');
		$this->db->select('kaito_su');
		$this->db->select('seikai_ritsu');
		$this->db->from('mondai');
		$this->db->join('user', 'user.user_id = mondai.shutsudaisha_id', 'left');
		$this->db->join("({$subquery}) AS setsumon_shukei", 'mondai.mondai_id = setsumon_shukei.setsumon_mondai_id', 'left');
		$this->db->where('mondai_id', $where['mondai_id']);
		return $this->row($this->db->get());
	}

	// 問題集計
	public function mondai_shukei($where = [])
	{
		$subquery = $this->setsumon_shukei($where);
		$this->db->select('shutsudaisha_id AS mondai_shutsudaisha_id');
		$this->db->select('COUNT(mondai_id) AS mondai_su');
		$this->db->select('SUM(setsumon_su) AS setsumon_su');
		$this->db->select('SUM(kaito_su) AS kaito_su');
		$this->db->from('mondai');
		$this->db->join("({$subquery}) AS setsumon_shukei", 'mondai.mondai_id = setsumon_shukei.setsumon_mondai_id', 'left');
		if (isset($where['shutsudaisha_id']))
		{
			$this->db->where('shutsudaisha_id', $where['shutsudaisha_id']);
		}
		$this->db->group_by('shutsudaisha_id');
		return $this->db->get_compiled_select();
	}

	// 設問集計
	public function setsumon_shukei($where = [])
	{
		$subquery = $this->kiroku_shukei($where, 'setsumon_id');
		$this->db->select('setsumon.mondai_id AS setsumon_mondai_id');
		$this->db->select('COUNT(setsumon.setsumon_id) AS setsumon_su');
		$this->db->select('SUM(kaito_su) AS kaito_su');
		$this->db->select('AVG(seikai_ritsu) AS seikai_ritsu');
		$this->db->from('setsumon');
		$this->db->join("({$subquery}) AS kiroku_shukei", 'setsumon.setsumon_id = kiroku_shukei.kiroku_setsumon_id', 'left');
		if (isset($where['shutsudaisha_id']))
		{
			$this->db->join('mondai', 'mondai.mondai_id = setsumon.mondai_id', 'left');
			$this->db->where('shutsudaisha_id', $where['shutsudaisha_id']);
		}
		if (isset($where['mondai_id']))
		{
			$this->db->where('mondai_id', $where['mondai_id']);
		}
		$this->db->group_by('setsumon.mondai_id');
		return $this->db->get_compiled_select();
	}

	// 記録集計
	public function kiroku_shukei($where = [], $group_by = NULL)
	{
		if ($group_by === 'kaitosha_id')
		{
			$this->db->select('kaitosha_id AS kiroku_kaitosha_id');
			$this->db->group_by('kaitosha_id');
		}
		if ($group_by === 'setsumon_id')
		{
			$this->db->select('kiroku.setsumon_id AS kiroku_setsumon_id');
			$this->db->group_by('kiroku.setsumon_id');
		}
		$this->db->select('COUNT(kiroku_id) AS kaito_su');
		$this->db->select('COUNT(seikai) / COUNT(kiroku_id) AS seikai_ritsu');
		$this->db->from('kiroku');
		if (isset($where['kaitosha_id']))
		{
			$this->db->where('kaitosha_id', $where['kaitosha_id']);
		}
		if (isset($where['shutsudai_id']))
		{
			$this->db->join('setsumon', 'setsumon.setsumon_id = kiroku.setsumon_id', 'left');
			$this->db->join('mondai', 'mondai.mondai_id = setsumon.mondai_id', 'left');
			$this->db->where('shutsudaisha_id', $where['shutsudaisha_id']);
		}
		if (isset($where['mondai_id']))
		{
			$this->db->select('AVG(millisec) AS millisec');
			$this->db->select('GROUP_CONCAT(gokaito) AS gokaito');
			$this->db->join('setsumon', 'setsumon.setsumon_id = kiroku.setsumon_id', 'left');
			$this->db->where('mondai_id', $where['mondai_id']);
		}
		if (isset($where['setsumon_id']))
		{
			$this->db->where('setsumon_id', $where['setsumon_id']);
		}
		return $this->db->get_compiled_select();
	}

	// 記録クリア
	public function kiroku_clear($where = [])
	{
		$query =
			'DELETE'."\n".
			'`kiroku` FROM `kiroku` LEFT JOIN `setsumon` ON `setsumon`.`setsumon_id` = `kiroku`.`setsumon_id`'."\n".
			'WHERE `kaitosha_id` = '.intval($where['kaitosha_id'])."\n".
			'AND `mondai_id` = '.intval($where['mondai_id'])
		;
		$this->db->query($query);
		return $this->db->affected_rows();
	}

	// 記録オールクリア
	public function kiroku_all_clear($where = [])
	{
		$this->db->where('kaitosha_id', $where['kaitosha_id']);
		$this->db->delete('kiroku');
		return $this->db->affected_rows();
	}

	private function result($query)
	{
		$rows = [];
		foreach ($query->result_array() as $row)
		{
			unset($row['password']);
			$rows[] = $row;
		}
		return $rows;
	}

	private function row($query)
	{
		$row = $query->row_array();
		unset($row['password']);
		return $row;
	}

}
