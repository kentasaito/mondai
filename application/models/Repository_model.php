<?php

class Repository_model extends MY_Model
{
	// ライセンスチェック
	private function validate_license($user)
	{
		if ($this->config->item(remote_repository) !== NULL)
		{
			chdir(FCPATH."mondai_data/{$user['repository']}");
			exec("diff ".FCPATH."application/direct/LICENSE LICENSE 2>&1", $output, $return_val);
			if ($return_val !== 0)
			{
				append_flash('licence_error', 'info', implode("\n", $output));
				return FALSE;
			}
			chdir(FCPATH);
		}
		return TRUE;
	}

	// CSVからDBへ同期
	private function csv2db($filename, $table, $where, $keys)
	{
		// SJIS-winならUTF-8へ変換
		if (($buffer = file_get_contents($filename)) === FALSE)
		{
			append_flash('csv_open_error', 'info', preg_replace('#^mondai_data/#', '', $filename));
			return FALSE;
		}
		$buffer = mb_convert_encoding($buffer, 'UTF-8', 'UTF-8, SJIS-win');
		$handle = tmpfile();
		fwrite($handle, $buffer);
		rewind($handle);
		$line_number = 0;
		while (($array = fgetcsv($handle)) !== FALSE)
		{
			if (count($keys) !== count($array))
			{
				append_flash('csv_read_error', 'info', preg_replace('#^mondai_data/#', '', [$filename, $line_number + 1]));
				return FALSE;
			}
			$rows[] = array_merge($where, array_combine($keys, $array));
			$line_number++;
		}
		fclose($handle);

		// 現存の問題を取得
		$this->db->from($table);
		foreach ($where as $key => $value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get();
		$ids = [];
		foreach ($query->result_array() as $row)
		{
			$ids[$row[$keys[0]]] = $row;
		}

		// INSERT or UPDATE
		foreach ($rows as $row)
		{
			if ( ! isset($ids[$row[$keys[0]]]))
			{
				$this->db->insert($table, $row);
			}
			else
			{
				foreach ($where as $key => $value)
				{
					$this->db->where($key, $value);
				}
				$this->db->where($keys[0], $row[$keys[0]]);
				$this->db->update($table, $row);
				unset($ids[$row[$keys[0]]]);
			}
		}

		// DELETE
		foreach ($ids as $id => $null)
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
			$this->db->where($keys[0], $id);
			$this->db->delete($table);
			unset($ids[$id]);
		}

		return TRUE;
	}

	// ワーキングツリーからDBへ同期
	private function tree2db($user)
	{
		// ライセンスチェック
		if ($this->validate_license($user) !== TRUE)
		{
			return FALSE;
		}

		// 問題を同期
		$return_val = $this->csv2db(
			"mondai_data/{$user['repository']}/index.csv",
			'mondai',
			['shutsudaisha_id' => $user['user_id']],
			['shutsudaisha_mondai_id', 'mondaimei']
		);
		if ($return_val !== TRUE)
		{
			return FALSE;
		}

		// 設問を同期
		$this->db->from('mondai');
		$this->db->where('shutsudaisha_id', $user['user_id']);
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$return_val = $this->csv2db(
				"mondai_data/{$user['repository']}/{$row['mondaimei']}.csv",
				'setsumon',
				['mondai_id' => $row['mondai_id']],
				['mondai_setsumon_id', 'mondaibun', 'seikaito']
			);
			if ($return_val !== TRUE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}
	
	// リポジトリ設定
	public function initialize($user_id, $array)
	{
		$this->db->trans_start();

		// ユーザ情報更新
		$row = [
			'user_id' => $user_id,
			'repository' => $array['repository'],
		];
		$return_val = $this->db->update_batch('user', [$row], 'user_id');
		if ($return_val !== 1)
		{
			return FALSE;
		}
		$user = $this->user($user_id);

		if ($this->config->item(remote_repository) !== NULL)
		{
			// ディレクトリ作成
			$return_val = mkdir(FCPATH."mondai_data/{$user['repository']}", 0755, TRUE);
			if ($return_val !== TRUE)
			{
				append_flash('mkdir_error', 'info');
				return FALSE;
			}

			// git clone
			exec("git clone {$this->config->item('remote_repository')}/{$user['repository']}.git ".FCPATH."mondai_data/{$user['repository']}", $output, $return_val);
			if ($return_val !== 0)
			{
				append_flash('git_clone_error', 'info');
				return FALSE;
			}
		}

		// DBへ問題を追加
		$return_val = $this->tree2db($user);
		if ($return_val !== TRUE)
		{
			return FALSE;
		}

		$this->db->trans_complete();
		return $user;
	}

	// リポジトリ同期
	public function synchronize($user_id)
	{
		$this->db->trans_start();

		$user = $this->user($user_id);

		$output = [];
		if ($this->config->item(remote_repository) !== NULL)
		{
			// git pull
			@exec('cd '.FCPATH."mondai_data/{$user['repository']}; git pull 2>&1", $output, $return_val);
			if ($return_val !== 0)
			{
				append_flash('git_pull_error', 'info', implode("\n", $output));
				return FALSE;
			}
		}

		// DBの問題を更新
		$return_val = $this->tree2db($user);
		if ($return_val !== TRUE)
		{
			return FALSE;
		}

		$this->db->trans_complete();
		return $output;
	}

	// リポジトリ削除
	public function purge($user_id)
	{
		$this->db->trans_start();

		$user = $this->user($user_id);

		// DBから問題を削除
		$this->db->where('shutsudaisha_id', $user['user_id']);
		$this->db->delete('mondai');

		// ディレクトリ削除
		exec('rm -rf '.FCPATH."mondai_data/{$user['repository']}");
		exec('find '.FCPATH.'mondai_data -type d -empty | xargs rm -rf');

		// ユーザ情報更新
		$row = [
			'user_id' => $user_id,
			'repository' => NULL,
		];
		$return_val = $this->db->update_batch('user', [$row], 'user_id');
		if ($return_val !== 1)
		{
			return FALSE;
		}

		$this->db->trans_complete();
		return $this->user($user_id);
	}

}
