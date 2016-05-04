<?php

class Mypage extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->user === NULL)
		{
			redirect('');
		}
		$this->load->model('mypage_model');
		$this->load->helper('file');
		$this->order_by = [
			'`kaito_su` ASC',
			'`seikai_ritsu` ASC',
			'`millisec` DESC',
		];
	}

	// マイページ
	public function index()
	{
		$this->mypage();
	}

	// ユーザ情報
	public function account()
	{
		load_view('template');
	}

	// リポジトリ
	public function repository()
	{
		load_view('template');
	}

	// 解答者一覧
	public function kaitosha_ichiran()
	{
		$this->vars['kaitoshas'] = $this->mypage_model->kaitosha_ichiran();
		load_view('template');
	}

	// 出題者一覧
	public function shutsudaisha_ichiran()
	{
		$this->vars['shutsudaishas'] = $this->mypage_model->shutsudaisha_ichiran();
		load_view('template');
	}

	// 問題一覧
	public function mondai_ichiran()
	{
		$this->vars['mondais'] = $this->mypage_model->mondai_ichiran();
		load_view('template');
	}

	// 解答者
	public function kaitosha($kaitosha_id)
	{
		$this->vars['kaitosha'] = $this->mypage_model->kaitosha($kaitosha_id);
		$this->vars['mondais'] = $this->mypage_model->mondai_ichiran(['kaitosha_id' => $kaitosha_id]);
		load_view('template');
	}

	// 出題者
	public function shutsudaisha($shutsudaisha_id)
	{
		$this->vars['shutsudaisha'] = $this->mypage_model->shutsudaisha($shutsudaisha_id);
		$this->vars['mondais'] = $this->mypage_model->mondai_ichiran(['shutsudaisha_id' => $shutsudaisha_id]);
		load_view('template');
	}

	// 問題
	public function mondai($mondai_id)
	{
		$this->vars['mondai'] = $this->mypage_model->mondai(['kaitosha_id' => $this->session->user['user_id'], 'mondai_id' => $mondai_id]);
		$this->vars['setsumons'] = $this->mypage_model->setsumon_ichiran(['kaitosha_id' => $this->session->user['user_id'], 'mondai_id' => $mondai_id], $this->order_by);
 		load_view('template');
	}

	// テスト
	public function test($mondai_id)
	{
		$this->vars['site_url'] = site_url('');
		$this->vars['mondai'] = $this->mypage_model->mondai(['kaitosha_id' => $this->session->user['user_id'], 'mondai_id' => $mondai_id]);
		$this->vars['shutsudai_su'] = $this->input->post('shutsudai_su');
		$this->vars['jido_check'] = $this->input->post('jido_check');
 		load_view('template');
	}

	// 設問
	public function setsumons($mondai_id, $shutsudai_su)
	{
		$extensions = ['png' => 'png', 'jpg' => 'jpeg', 'gif' => 'gif'];
		$this->vars['mondai'] = $this->mypage_model->mondai(['kaitosha_id' => $this->session->user['user_id'], 'mondai_id' => $mondai_id]);
		$shutsudaisha = $this->mypage_model->shutsudaisha($this->vars['mondai']['user_id']);
		$this->vars['repository'] = $shutsudaisha['repository'];
		$rows = $this->mypage_model->setsumon_ichiran(['mondai_id' => $mondai_id], $this->order_by, $shutsudai_su);
		foreach ($rows as $row)
		{
			foreach (array_keys($extensions) as $extension)
			{
				$filename = "{$this->vars['repository']}/{$this->vars['mondai']['mondaimei']}.{$row['mondai_setsumon_id']}.{$extension}";
				if (file_exists(FCPATH."mondai_data/$filename"))
				{
					$row['image'] = $filename;
					break;
				}
			}
			$this->vars['setsumons'][] = $row;
		}
		shuffle($this->vars['setsumons']);
		echo json_encode($this->vars);
	}

	// 画像
	public function setsumon_image()
	{
		header('Content-type: image');
		readfile(FCPATH."mondai_data/{$this->input->get('filename')}");
	}

	// 記録クリア
	public function kiroku_clear($mondai_id)
	{
		$this->mypage_model->kiroku_clear(['kaitosha_id' => $this->session->user['user_id'], 'mondai_id' => $mondai_id]);
		redirect("mypage/mondai/{$mondai_id}");
	}

	// 記録オールクリア
	public function kiroku_all_clear()
	{
		$this->mypage_model->kiroku_all_clear(['kaitosha_id' => $this->session->user['user_id']]);
		redirect('mypage/account');
	}

}
