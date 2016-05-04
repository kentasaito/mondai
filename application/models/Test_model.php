<?php

class Test_model extends CI_Model
{
	// 正解
	public function seikai($kaitosha_id, $setsumon_id, $millisec)
	{
		$this->db->trans_start();
		$row = [
			'kaitosha_id' => $kaitosha_id,
			'setsumon_id' => $setsumon_id,
			'seikai' => 1,
			'millisec' => $millisec,
		];
		if (($return_val = $this->db->insert_batch('kiroku', [$row])) !== 1)
		{
			return FALSE;
		}
		$this->koshin($kaitosha_id, $setsumon_id, $this->config->item('kaitosha_setsumon_kiroku_su'));
		$this->db->trans_complete();
		return TRUE;
	}

	// 不正解
	public function fuseikai($kaitosha_id, $setsumon_id, $gokaito)
	{
		$this->db->trans_start();
		$row = [
			'kaitosha_id' => $kaitosha_id,
			'setsumon_id' => $setsumon_id,
			'fuseikai' => 1,
			'gokaito' => $gokaito,
		];
		if (($return_val = $this->db->insert_batch('kiroku', [$row])) !== 1)
		{
			return FALSE;
		}
		$this->koshin($kaitosha_id, $setsumon_id, $this->config->item('kaitosha_setsumon_kiroku_su'));
		$this->db->trans_complete();
		return TRUE;
	}

	// パス
	public function pass($kaitosha_id, $setsumon_id)
	{
		$this->db->trans_start();
		$row = [
			'kaitosha_id' => $kaitosha_id,
			'setsumon_id' => $setsumon_id,
			'pass' => 1,
		];
		if (($return_val = $this->db->insert_batch('kiroku', [$row])) !== 1)
		{
			return FALSE;
		}
		$this->koshin($kaitosha_id, $setsumon_id, $this->config->item('kaitosha_setsumon_kiroku_su'));
		$this->db->trans_complete();
		return TRUE;
	}

	// 更新
	private function koshin($kaitosha_id, $setsumon_id, $kensu)
	{
		$this->db->select('COUNT(kiroku_id) AS kiroku_su');
		$this->db->from('kiroku');
		$this->db->where('kaitosha_id', $kaitosha_id);
		$this->db->where('setsumon_id', $setsumon_id);
		$kiroku_su = $this->db->get()->row_array()['kiroku_su'];
		$limit = $kiroku_su - $kensu;
		if ($limit > 0)
		{
			$this->db->where('kaitosha_id', $kaitosha_id);
			$this->db->where('setsumon_id', $setsumon_id);
			$this->db->limit($limit);
			$this->db->delete('kiroku');
		}
	}

}
