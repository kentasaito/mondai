<h1><?php h($this->session->user['user_name']); ?>さんのユーザ情報</h1>
<?php load_view('flash'); ?>

<form method="post" action="<?php href('auth/update'); ?>">
	<div class="form-group">
		<label>表示名</label>
		<input type="text" name="user_name" value="<?php h($this->session->user['user_name']); ?>" class="form-control" placeholder="問題 太郎" minlength="2" required>
	</div>
	<div class="form-group">
		<label>ログイン名</label>
		<input type="text" name="login" value="<?php h($this->session->user['login']); ?>" class="form-control" placeholder="taro_mondai" minlength="4" required>
	</div>
	<div class="form-group">
		<label>パスワード <button type="button" onclick="$([name=password]).val(''); $([name=password]).attr('disabled', ! $([name=password]).attr('disabled'))" class="btn btn-sm btn-default">変更する</button></label>
		<input type="password" name="password" disabled="disabled" class="form-control" minlength="8" required>
	</div>
	<button type="submit" class="btn btn-default">更新</button>
	<a href="<?php href('mypage/kiroku_all_clear'); ?>" class="btn btn-warning">記録を全てクリア</a>
	<a href="<?php href('auth/unsubscribe'); ?>" class="btn btn-danger">登録解除</a>
</form>
<script>
$('form').validate();
</script>
