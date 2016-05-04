<h1>問題</h1>
<?php load_view('flash'); ?>

<table class="table">
<tr>
<th>出題者</th>
<th>問題名</th>
<th class="text-center">設問数</th>
<th class="text-center">解答数</th>
<tr>
<?php foreach ($vars['mondais'] as $row): ?>
<tr>
<td><a href="<?php href("mypage/shutsudaisha/{$row['user_id']}"); ?>"><?php h($row['user_name']); ?></a></td>
<td><a href="<?php href("mypage/mondai/{$row['mondai_id']}"); ?>"><?php h($row['mondaimei']); ?></a></td>
<td class="text-center"><?php h($row['setsumon_su']); ?></td>
<td class="text-center"><?php h($row['kaito_su']); ?></td>
<tr>
<?php endforeach; ?>
</table>
