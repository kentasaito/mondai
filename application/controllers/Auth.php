<?php

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}

	// ユーザ登録
	public function register()
	{
		if (($return_val = $this->auth_model->register($this->input->post())) !== 1)
		{
			append_flash('register_failed', 'warning', $this->input->post('login'));
			redirect('welcome/registration');
		}
		append_flash('register_sucseeded');
		redirect('');
	}

	// ユーザ情報更新
	public function update()
	{
		if ( ! is_array($return_val = $this->auth_model->update($this->session->user['user_id'], $this->input->post())))
		{
			append_flash('update_failed', 'warning', $this->input->post('login'));
			redirect('mypage/account');
		}
		$this->session->user = $return_val;
		append_flash('update_sucseeded');
		redirect('mypage');
	}

	// 登録解除
	public function unsubscribe()
	{
		if (($return_val = $this->auth_model->unsubscribe($this->session->user['user_id'])) !== 1)
		{
			append_flash('unsubscribe_failed', 'warning');
			redirect('mypage/account');
		}
		$this->session->user = NULL;
		append_flash('unsubscribe_sucseeded');
		redirect('');
	}

	// ログイン
	public function login()
	{
		if ( ! is_array($return_val = $this->auth_model->authenticate($this->input->post())))
		{
			append_flash('login_failed', 'warning', $this->input->post('login'));
			redirect('');
		}
		$this->session->user = $return_val;
		append_flash('login_sucseeded', 'success', $this->session->user['user_name']);
		redirect('mypage');
	}

	// ログアウト
	public function logout()
	{
		$user_name = $this->session->user['user_name'];
		$this->session->user = NULL;
		append_flash('logout_sucseeded', 'success', $user_name);
		redirect('');
	}

}
