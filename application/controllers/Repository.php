<?php

class Repository extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('repository_model');
	}

	// リポジトリ設定
	public function initialize()
	{
		if ( ! is_array($return_val = $this->repository_model->initialize($this->session->user['user_id'], $this->input->post())))
		{
			$this->repository_model->purge($this->session->user['user_id']);
			append_flash('initialize_failed', 'warning', $this->input->post('repository'));
			redirect('mypage/repository');
		}
		$this->session->user = $return_val;
		append_flash('initialize_sucseeded');
		redirect("mypage/shutsudaisha/{$this->session->user['user_id']}");
	}

	// リポジトリ同期
	public function synchronize()
	{
		if ( ! is_array($return_val = $this->repository_model->synchronize($this->session->user['user_id'])))
		{
			append_flash('synchronize_failed', 'warning');
			redirect('mypage/repository');
		}
		append_flash('synchronize_sucseeded', 'success', implode("\n", $return_val));
		redirect("mypage/shutsudaisha/{$this->session->user['user_id']}");
	}

	// リポジトリ削除
	public function purge()
	{
		if ( ! is_array($return_val = $this->repository_model->purge($this->session->user['user_id'])))
		{
			append_flash('purge_failed', 'warning');
			redirect('mypage/repository');
		}
		$this->session->user = $return_val;
		append_flash('purge_sucseeded');
		redirect('mypage');
	}

}
