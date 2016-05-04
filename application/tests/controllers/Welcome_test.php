<?php

class Welcome_test extends TestCase
{
	// トップページ
	public function test_welcome()
	{
		$output = $this->request('GET', ['welcome', 'index']);
		$this->assertResponseCode(200);
	}

	// トップページ (ログイン済み)
	public function test_welcome_already_logged()
	{
		$this->login();
		$output = $this->request('GET', ['welcome', 'index']);
		$this->assertRedirect('mypage');
	}

}
