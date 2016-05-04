<?php

class Reository_test extends TestCase
{
	// リポジトリ設定
	public function test_initialize()
	{
		$this->login();
		$output = $this->request('POST', ['repository', 'initialize'], ['repository' => 'kentasaito/mondai_data']);
		$this->assertRedirect("mypage/shutsudaisha/{$this->CI->session->user['user_id']}");
	}

	// リポジトリ設定 (失敗)
	public function test_initialize_fail()
	{
		$this->login();
		$output = $this->request('GET', ['repository', 'initialize']);
		$this->assertRedirect('mypage/repository');
	}

	// リポジトリ同期
	public function test_synchronize()
	{
		$this->login();
		$output = $this->request('GET', ['repository', 'synchronize']);
		$this->assertRedirect("mypage/shutsudaisha/{$this->CI->session->user['user_id']}");
	}

	// リポジトリ削除
	public function test_purge()
	{
		$this->login();
		$output = $this->request('GET', ['repository', 'purge']);
		$this->assertRedirect('mypage');
	}

	// リポジトリ同期 (失敗)
	public function test_synchronize_fail()
	{
		$this->login();
		$output = $this->request('GET', ['repository', 'synchronize']);
		$this->assertRedirect('mypage/repository');
	}

	// リポジトリ削除 (失敗)
	public function test_purge_fail()
	{
		$this->login();
		$output = $this->request('GET', ['repository', 'purge']);
		$this->assertRedirect('mypage/repository');
	}

}
