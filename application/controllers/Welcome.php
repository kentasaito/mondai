<?php

class Welcome extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	// トップページ
	public function index()
	{
		if ($this->session->user !== NULL)
		{
			$this->mypage();
		}
		load_view('template');
	}

	// ユーザ情報入力
	public function registration()
	{
		load_view('template');
	}

}
