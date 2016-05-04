<?php

class Test extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->user === NULL)
		{
			redirect('');
		}
		$this->load->model('test_model');
	}

	// 正解
	public function seikai($setsumon_id)
	{
		$this->test_model->seikai($this->session->user['user_id'], $setsumon_id, $this->input->post('millisec'));
	}

	// 不正解
	public function fuseikai($setsumon_id)
	{
		$this->test_model->fuseikai($this->session->user['user_id'], $setsumon_id, $this->input->post('gokaito'));
	}

	// パス
	public function pass($setsumon_id)
	{
		$this->test_model->pass($this->session->user['user_id'], $setsumon_id);
	}

}
