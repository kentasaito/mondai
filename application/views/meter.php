<?php $percentage = 100 * $vars['val'] / $vars['max']; ?>
<?php $class = $percentage == 100 ? 'progress-bar-info' : ($percentage > 67 ? 'progress-bar-success' : ($percentage > 34 ? 'progress-bar-warning' : 'progress-bar-danger')); ?>
<div><span class="val"><?php h(floor($vars['val'])); ?></span><span><?php if (isset($vars['unit'])) h($vars['unit']); ?></span></div>
<div class="progress">
	<div max="<?php h($vars['max']); ?>" class="progress-bar <?php h($class); ?>" style="width:<?php h($percentage); ?>%;"></div>
</div>
