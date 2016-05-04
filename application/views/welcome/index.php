<div class="text-center">
<img id="logo-top" src="<?php direct('img/mondai.svg'); ?>"><br>
<img id="symbol-top" src="<?php direct('img/gijineko.svg'); ?>">
<?php if ( ! in_array('logout_sucseeded', array_column($this->session->flash, 'name'))): ?>
<?php if ( ! in_array('registration', $vars['restrictions'])): ?>
<div class="alert alert-info" role="alert">
初めての人は<a href="<?php href('welcome/registration'); ?>" class="alert-link">ユーザ登録</a>
</div>
<?php endif; ?>
<?php endif; ?>
<?php load_view('flash'); ?>

<form method="post" action="<?php href('auth/login'); ?>" class="form-inline">
	<div class="form-group">
		<label>ログイン名</label>
		<input type="text" name="login" class="form-control" placeholder="taro_mondai">
	</div>
	<div class="form-group">
		<label>パスワード</label>
		<input type="password" name="password" class="form-control">
	</div>
	<button type="submit" class="btn btn-default" onclick="preloadAudio();">ログイン</button>
</form>
</div>
