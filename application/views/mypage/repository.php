<h1>リポジトリ</h1>
<?php load_view('flash'); ?>

<?php if ($this->session->user['repository'] === NULL): ?>
<h2>設定</h2>
<div class="well">
<p>
リポジトリを設定することによってmondaiに問題を出題できるようになります。<br>
出題の手順はユーザガイドをご覧ください。<br>
</p>
<form method="post" action="<?php href('repository/initialize'); ?>" class="form-inline">
	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon"><?php h($this->config->item('remote_repository')); ?>/</div>
			<input type="text" name="repository" class="form-control" placeholder="taro_mondai/mondai_data" required>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">設定</button>
</form>
<script>
$.validator.addMethod('repository', function(value, element) {
	return this.optional(element) || /[^\/]+\/mondai_data(_.*)*$/.test(value);
}, "mondai_dataで始めてください。");
$('form').validate({
	rules: {
		repository: 'repository',
	}
});
</script>

</div>
<?php else: ?>
<h2>あなたのリモートリポジトリ</h2>
<div class="well lead">
<a target="_blank" href="<?php h($this->config->item('remote_repository')); ?>/<?php h($this->session->user['repository']); ?>"><?php h($this->config->item('remote_repository')); ?>/<?php h($this->session->user['repository']); ?></a>
</div>

<h2>同期</h2>
<div class="well">
<p>
リモートリポジトリを更新したときに同期してください。<br>
同期が完了すると問題に反映されます。<br>
</p>
<a href="<?php href('repository/synchronize'); ?>" class="btn btn-primary">同期</a>
</div>

<h2>削除</h2>
<div class="well">
<p>
あなたの出題した問題への、全てのユーザの解答記録も削除されます。<br>
<a href="<?php href('repository/purge'); ?>" class="btn btn-danger">削除</a>
</p>
</div>
<?php endif; ?>
