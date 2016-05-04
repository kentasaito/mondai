<h1><?php h($vars['shutsudaisha']['user_name']); ?>さん</h1>
<?php load_view('flash'); ?>
<?php $row = $vars['shutsudaisha']; ?>

<div class="well">
<strong>リポジトリ</strong>:
<span><a target="_blank" href="<?php h($this->config->item('remote_repository')); ?>/<?php h($row['repository']); ?>"><?php h($row['repository']); ?></a></span> /
<strong>問題数</strong>:
<span><?php h($row['mondai_su']); ?></span> /
<strong>設問数</strong>:
<span><?php h($row['setsumon_su']); ?></span> /
<strong>解答数</strong>:
<span><?php h($row['kaito_su']); ?></span>
</div>

<h2><?php h($vars['shutsudaisha']['user_name']); ?>さんからの問題</h2>
<table class="table">
<tr>
<th>問題名</th>
<th class="text-center">設問数</th>
<th class="text-center">解答数</th>
<tr>
<?php foreach ($vars['mondais'] as $row): ?>
<tr>
<td><a href="<?php href("mypage/mondai/{$row['mondai_id']}"); ?>"><?php h($row['mondaimei']); ?></a></td>
<td class="text-center"><?php h($row['setsumon_su']); ?></td>
<td class="text-center"><?php h($row['kaito_su']); ?></td>
<tr>
<?php endforeach; ?>
</table>
