<?php

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->user !== NULL)
		{
			$this->mypage();
		}
	}

	// トップページ
	public function index()
	{
		load_view('template');
	}

	// ユーザ情報入力
	public function registration()
	{
		load_view('template');
	}

}
