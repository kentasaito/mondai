<h1>ユーザ登録</h1>
<a href="<?php href(''); ?>">トップページへ戻る</a>
<?php load_view('flash'); ?>

<form method="post" action="<?php href('auth/register'); ?>">
	<div class="form-group">
		<label>表示名</label>
		<input type="text" name="user_name" class="form-control" placeholder="問題 太郎" minlength="2" required>
	</div>
	<div class="form-group">
		<label>ログイン名</label>
		<input type="text" name="login" class="form-control" placeholder="taro_mondai" minlength="4" required>
	</div>
	<div class="form-group">
		<label>パスワード</label>
		<input type="password" name="password" class="form-control" minlength="8" required>
	</div>
	<button type="submit" class="btn btn-default">登録</button>
</form>
<script>
$("form").validate();
</script>
