<?php

class Docs extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	// ユーザガイド
	public function index()
	{
		$this->vars['view'] = $this->uri->uri_string();
		if ($this->vars['view'] === 'docs')
		{
			$this->vars['view'] = 'docs/index';
		}
		load_view('template');
	}

}
