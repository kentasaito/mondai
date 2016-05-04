<?php

class Mypage_test extends TestCase
{
	// マイページ (未ログイン)
	public function test_mypage_not_logged_in()
	{
		$output = $this->request('GET', ['mypage', 'index']);
		$this->assertRedirect('');
	}

	// マイページ
	public function test_mypage()
	{
		$this->login();
		$output = $this->request('GET', ['mypage', 'index']);
		$this->assertResponseCode(200);
	}

}
