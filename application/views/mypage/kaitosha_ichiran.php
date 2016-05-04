<h1>解答者</h1>
<?php load_view('flash'); ?>

<table class="table">
<tr>
<th>解答者</th>
<th class="text-center">解答数</th>
<tr>
<?php foreach ($vars['kaitoshas'] as $row): ?>
<tr>
<td><a href="<?php href("mypage/kaitosha/{$row['user_id']}"); ?>"><?php h($row['user_name']); ?></a></td>
<td class="text-center"><?php h($row['kaito_su']); ?></td>
<tr>
<?php endforeach; ?>
</table>
