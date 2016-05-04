<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php direct('vendor/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php direct('css/default.css'); ?>" rel="stylesheet">
		<script src="<?php direct('vendor/jquery.min.js'); ?>"></script>
		<script src="<?php direct('vendor/jquery.validate.min.js'); ?>"></script>
		<script src="<?php direct('vendor/bootstrap.min.js'); ?>"></script>
	</head>
	<body>
		<div id="contents">
<?php load_view('contents'); ?>
		</div>
		<footer class="container text-center">
			<hr>
			<a href="<?php href('docs/about'); ?>">mondaiについて</a> |
			<a href="<?php href('docs/'); ?>">ユーザガイド</a>
		</footer>
		<audio id="audio_shutsudai" preload="auto"><source src="<?php direct('sound/Sys_Set01-sentaku.mp3'); ?>" type="audio/mp3"></audio>
		<audio id="audio_fuseikai" preload="auto"><source src="<?php direct('sound/Quiz-Wrong_Buzzer02-1.mp3'); ?>" type="audio/mp3"></audio>
		<audio id="audio_shuryo" preload="auto"><source src="<?php direct('sound/Accent03-3.mp3'); ?>" type="audio/mp3"></audio>
		<script>var config_use_ajax = <?php h($this->config->item('use_ajax') === TRUE ? 'true' : 'false'); ?>;</script>
		<script src="<?php direct('js/ajax.js'); ?>"></script>
	</body>
</html>
