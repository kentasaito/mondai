<?php

class TestCase extends CIPHPUnitTestCase
{
	public function __construct()
	{
		parent::__construct();
		shell_exec('mysql mondai_dev < '.APPPATH.'docs/mondai.dump');
	}

	// ユーザ登録
	public function register()
	{
		$output = $this->request('POST', ['auth', 'register'], [
			'user_name' => '問題 太郎',
			'login' => 'taro_mondai',
			'password' => 'password',
		]);
		return $output;
	}

	// ユーザ情報更新
	public function update()
	{
		$output = $this->request('POST', ['auth', 'update'], [
			'user_name' => '問題 太郎 (更新済み)',
			'login' => 'taro_mondai',
		]);
		return $output;
	}

	// ユーザ情報更新 (失敗)
	public function update_fail()
	{
		$output = $this->request('POST', ['auth', 'register'], [
			'user_name' => '問題 二郎',
			'login' => 'jiro_mondai',
			'password' => 'password',
		]);
		$output = $this->request('POST', ['auth', 'update'], [
			'user_name' => '問題 二郎 (同名で登録済み)',
			'login' => 'jiro_mondai',
			'password' => 'password_updated',
		]);
		return $output;
	}

	// 登録解除
	public function unsubscribe()
	{
		$output = $this->request('GET', ['auth', 'unsubscribe']);
		return $output;
	}

	// ログイン
	public function login()
	{
		$output = $this->request('POST', ['auth', 'login'], [
			'login' => 'taro_mondai',
			'password' => 'password',
		]);
		return $output;
	}

	// ログイン (失敗)
	public function login_fail()
	{
		$output = $this->request('POST', ['auth', 'login'], [
			'login' => 'taro_mondai',
			'password' => 'wrong_password',
		]);
		return $output;
	}

}
