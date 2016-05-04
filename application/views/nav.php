<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php href(''); ?>">
				<img id="logo-brand" src="<?php direct('img/mondai.svg'); ?>">
			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
<?php if ($this->session->user !== NULL): ?>
			<ul class="nav navbar-nav">
				<li><a href="<?php href('mypage/kaitosha_ichiran'); ?>">解答者</a></li>
				<li><a href="<?php href('mypage/shutsudaisha_ichiran'); ?>">出題者</a></li>
				<li><a href="<?php href('mypage/mondai_ichiran'); ?>">問題</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php href('mypage/account'); ?>"><?php h($this->session->user['user_name']); ?>さん</a></li>
				<li><a href="<?php href('mypage/repository'); ?>">リポジトリ</a></li>
				<li><a href="<?php href('auth/logout'); ?>">ログアウト</a></li>
			</ul>
<?php else: ?>
			<ul class="nav navbar-nav">
				<li><a href="<?php href('welcome/registration'); ?>">ユーザ登録</a></li>
			</ul>
<?php endif; ?>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>
