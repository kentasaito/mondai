<h1><?php h($vars['mondai']['mondaimei']); ?></h1>
<?php load_view('flash'); ?>
<?php $row = $vars['mondai']; ?>

<table class="table property">
<tr>
<th>出題者</th>
<td><a href="<?php href("mypage/shutsudaisha/{$row['user_id']}"); ?>"><?php h($row['user_name']); ?></a>さん</td>
<th>設問数</th>
<td><?php h($row['setsumon_su']); ?></td>
<th>解答数</th>
<td class="meter"><?php if ($row['kaito_su'] !== NULL): ?><?php load_view('meter', ['val' => $row['kaito_su'], 'max' => $this->config->item('kaitosha_setsumon_kiroku_su') * $row['setsumon_su'], 'unit' => ' / '.$this->config->item('kaitosha_setsumon_kiroku_su') * $row['setsumon_su']]); ?><?php else: ?>-<?php endif; ?></td>
<th>正解率</th>
<td class="meter"><?php if ($row['seikai_ritsu'] !== NULL): ?><?php load_view('meter', ['val' => 100 * $row['seikai_ritsu'], 'max' => 100, 'unit' => '%']); ?><?php else: ?>-<?php endif; ?></td>
</tr>
</table>

<form method="post" action="<?php href("mypage/test/{$vars['mondai']['mondai_id']}"); ?>" class="form-inline">
	<div class="form-group">
		<label>出題数</label>
		<input type="text" name="shutsudai_su" value="<?php h(min(10, $row['setsumon_su'])); ?>" class="form-control" style="width: 4em; text-align: right;">
	</div>
	<div class="form-group">
		<label>自動チェック</label>
		<input type="checkbox" name="jido_check" value="1" class="form-control">
	</div>
	<button type="submit" class="btn btn-primary">テスト開始</button>
	<a href="<?php href("mypage/kiroku_clear/{$vars['mondai']['mondai_id']}"); ?>" class="btn btn-warning">この問題の記録をクリア</a>
</form>

<script>
var seikaito_hyoji = false;
function toggle_seikaito()
{
	seikaito_hyoji = ! seikaito_hyoji;
	$('.seikaito').css('display', seikaito_hyoji ? 'inline' : 'none');
}
</script>
<h2>あなたの解答記録</h2>
<table class="table">
<tr>
<th class="text-center">#</th>
<th>問題文</th>
<th>正解 <button onclick="toggle_seikaito();" class="btn btn-default btn=sm">表示</button></th>
<th class="text-center">解答数</th>
<th class="text-center">正解率</th>
<th class="text-center">秒数</th>
<th>誤解答</th>
<tr>
<?php foreach ($vars['setsumons'] as $row): ?>
<tr>
<td class="text-center"><?php h($row['mondai_setsumon_id']); ?></td>
<td>
<?php if (mb_strlen($row['mondaibun']) > 32): ?><span title="<?php h($row['mondaibun']); ?>"><?php h(mb_substr($row['mondaibun'], 0, 32)); ?>…</span>
<?php else: ?><?php h($row['mondaibun']); ?>
<?php endif; ?>
</td>
<td><span class="seikaito" style="display: none;"><?php h($row['seikaito']); ?></span></td>
<td class="text-center meter">
<?php if ($row['kaito_su'] !== NULL): ?><?php load_view('meter', ['val' => $row['kaito_su'], 'max' => $this->config->item('kaitosha_setsumon_kiroku_su'), 'unit' => " / {$this->config->item('kaitosha_setsumon_kiroku_su')}"]); ?><?php endif; ?>
</td>
<td class="text-center meter">
<?php if ($row['seikai_ritsu'] !== NULL): ?><?php load_view('meter', ['val' => 100 * $row['seikai_ritsu'], 'max' => 100, 'unit' => '%']); ?><?php endif; ?>
</td>
<td class="text-center"><?php if ($row['millisec'] !== NULL) h(sprintf('%.1f', floor($row['millisec'] / 100) / 10)); ?></td>
<td><?php h($row['gokaito']); ?></td>
<tr>
<?php endforeach; ?>
</table>
