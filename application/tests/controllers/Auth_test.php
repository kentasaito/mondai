<?php

class Auth_test extends TestCase
{
	// ユーザ登録
	public function test_register()
	{
		$output = $this->register();
		$this->assertRedirect('');
	}

	// ユーザ登録 (失敗)
	public function test_register_fail()
	{
		$output = $this->register();
		$this->assertRedirect('welcome/registration');
	}

	// ユーザ情報更新
	public function test_update()
	{
		$output = $this->login();
		$output = $this->update();
		$this->assertInternalType('array', $this->CI->session->user);
		$this->assertRedirect('mypage');
	}

	// ユーザ情報更新 (失敗)
	public function test_update_fail()
	{
		$output = $this->login();
		$output = $this->update_fail();
		$this->assertRedirect('mypage/account');
	}

	// 登録解除
	public function test_unsubscribe()
	{
		$output = $this->login();
		$output = $this->unsubscribe();
		$this->assertNull($this->CI->session->user);
		$this->assertRedirect('');
		$output = $this->register();
	}

	// 登録解除 (失敗)
	public function test_unsubscribe_fail()
	{
		$output = $this->unsubscribe();
		$this->assertRedirect('mypage/account');
	}

	// ログイン
	public function test_login()
	{
		$output = $this->login();
		$this->assertInternalType('array', $this->CI->session->user);
		$this->assertRedirect('mypage');
	}

	// ログイン (失敗)
	public function test_login_fail()
	{
		$output = $this->login_fail();
		$this->assertNull($this->CI->session->user);
		$this->assertRedirect('');
	}

	// ログアウト
	public function test_logout()
	{
		$output = $this->request('GET', ['auth', 'logout']);
		$this->assertNull($this->CI->session->user);
		$this->assertRedirect('');
	}

}
