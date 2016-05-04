<?php

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		session_save_path (FCPATH.'tmp/session');
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('view');
		$this->load->config('application');
		$this->vars = [];
		if ($this->session->flash === NULL)
		{
			$this->session->flash = [];
		}
		if ($this->config->item('use_ajax') && ! $this->input->is_ajax_request() && $this->uri->ruri_string() !== 'welcome/index')
		{
			redirect('');
		}
		$this->vars['restrictions'] = $this->config->item('restrictions')[$this->session->user === NULL ? -1 : $this->session->user['admin']];
		if ($this->vars['restrictions'] === NULL)
		{
			$this->vars['restrictions'] = [];
		}
	}

	// マイページ
	public function mypage()
	{
		$this->load->model('mypage_model');
		$this->vars['kaitosha'] = $this->mypage_model->kaitosha($this->session->user['user_id']);
		$this->vars['mondais'] = $this->mypage_model->mondai_ichiran(['kaitosha_id' => $this->session->user['user_id']]);
		$this->vars['view'] = 'mypage/index';
		load_view('template');
		exit();
	}

}
