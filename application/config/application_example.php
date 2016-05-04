<?php

// リモートリポジトリ
$config['remote_repository'] = 'https://github.com';

// 設問あたりの記録数
$config['kaitosha_setsumon_kiroku_su'] = 3;

// Ajax
$config['use_ajax'] = TRUE;

// 制限
$config['restrictions'] = [
	// ログイン前
	'-1' => [
//		'registration', // ユーザ登録
	],
	// 一般ユーザ
	'0' => [
//		'registration', // ユーザ登録
//		'kaitosha',     // 解答者情報
//		'repository',   // リポジトリ操作
	],
	// 管理者
	'1' => [
	],
];
