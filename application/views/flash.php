<?php
$messages = [
	// 認証
	'register_failed' => '使用されているログイン名です。($1)',
	'register_sucseeded' => 'ユーザ登録が完了しました。',
	'update_failed' => '更新できませんでした。(変更箇所がないか使用されているログイン名です)',
	'update_sucseeded' => 'ユーザ情報を更新しました。',
	'unsubscribe_failed' => '登録解除できませんでした。問題が解決しないときはお問い合わせください。',
	'unsubscribe_sucseeded' => 'mondaiのユーザ登録解除しました。ご利用ありがとうございました。',
	'login_failed' => 'ログイン名またはパスワードが違います。($1)',
	'login_sucseeded' => 'ログインしました。こんにちは、$1さん!',
	'logout_sucseeded' => 'ログアウトしました。またお会いしましょう、$1さん!',

	// リポジトリ
	'initialize_failed' => "リポジトリを設定できませんでした。(既に設定済みの可能性があります)\n問題が解決しないときはお問い合わせください。($1)",
	'initialize_sucseeded' => "リポジトリを設定しました。出題をありがとうございます!\nあなたの出題した問題が正しく表示されるか確認してください。\nリポジトリを更新したときはリポジトリ設定ページから同期を行ってください。",
	'synchronize_failed' => '同期できませんでした。問題が解決しないときはお問い合わせください。',
	'synchronize_sucseeded' => "同期が完了しました。\n$1\nあなたの出題した問題が正しく更新されているか確認してください。",
	'purge_failed' => "リポジトリ設定を削除できませんでした。(既に削除済みの可能性があります)\n問題が解決しないときはお問い合わせください。",
	'purge_sucseeded' => 'リポジトリ設定を削除しました。出題をありがとうございました!',

	// リポジトリエラー
	'licence_error' => "ライセンスファイルが不正です。\n$1",
	'csv_open_error' => 'CSVファイルが開けません。($1)',
	'csv_read_error' => 'フィールド数が不正です。($1:$2行目)',
	'mkdir_error' => 'ワーキングツリー用ディレクトリが作成できません。(既に作成済みの可能性があります)',
	'git_clone_error' => 'リモートリポジトリからcloneできません。(リモートリポジトリが存在しない可能性があります)',
	'git_pull_error' => "リモートリポジトリからpullできません。(リモートリポジトリが存在しない可能性があります)\n$1",
];
?>
<?php foreach ($this->session->flash as $array): ?>
<div class="alert alert-<?php h($array['type']); ?>" role="alert">
<?php $message = $messages[$array['name']]; ?>
<?php if ( ! is_array($array['data'])) $array['data'] = [$array['data']]; ?>
<?php foreach ($array['data'] as $key => $value) $message = str_replace('$'.($key + 1), $value, $message); ?>
<?php h($message, 'nl2br'); ?>
</div>
<?php endforeach; ?>
<?php $this->session->flash = NULL; ?>
