<?php
$label = $args['label'] ?? '';
$title = $args['title'] ?? '';
$descr = $args['descr'] ?? '';
$tag_h1 = $args['tag_h1'] ?? false;
$h1 = $args['h1'] ?? false;
$class_title = $tag_h1 ? 'section-header__title descr title-1' : 'section-header__title descr title-2';
if (!empty($label) || !empty($title) || !empty($descr)): ?>
	<div class="section-header">
		<?php if (!empty($label)): ?>
			<p class="section-header__label label">
				<?php echo esc_html($label) ?>
			</p>
		<?php endif; ?>
		<?php if ($h1): ?>
			<h1 class="<?= esc_attr($class_title) ?>">
				<?php echo wp_kses_post($title) ?>
			</h1>
		<?php else: ?>
			<h2 class="<?= esc_attr($class_title) ?>">
				<?php echo wp_kses_post($title) ?>
			</h2>
		<?php endif; ?>
		<?php if (!empty($descr)): ?>
			<div class="section-header__descr descr descr-list">
				<?php echo wp_kses_post($descr) ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>