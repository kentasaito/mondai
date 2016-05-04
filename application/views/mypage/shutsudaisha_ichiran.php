<h1>出題者</h1>
<?php load_view('flash'); ?>

<table class="table">
<tr>
<th>解答者</th>
<th>リポジトリ</th>
<th class="text-center">問題数</th>
<th class="text-center">設問数</th>
<th class="text-center">解答数</th>
<tr>
<?php foreach ($vars['shutsudaishas'] as $row): ?>
<tr>
<td><a href="<?php href("mypage/shutsudaisha/{$row['user_id']}"); ?>"><?php h($row['user_name']); ?></a></td>
<td><a target="_blank" href="<?php h($this->config->item('remote_repository')); ?>/<?php h($row['repository']); ?>"><?php h($row['repository']); ?></a></td>
<td class="text-center"><?php h($row['mondai_su']); ?></td>
<td class="text-center"><?php h($row['setsumon_su']); ?></td>
<td class="text-center"><?php h($row['kaito_su']); ?></td>
<tr>
<?php endforeach; ?>
</table>
