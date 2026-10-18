<?php

// Получаем поля ACF
$label = get_field('simple_process_label') ?? '';
$title = get_field('simple_process_title') ?? '';
$descr = get_field('simple_process_descr') ?? '';
$steps = get_field('simple_process_steps') ?? [];

// Если нет ни заголовка, ни шагов — не выводим секцию
if (!$title && empty($steps)) {
	return;
}
?>

<section class="section simple-process" id="simple-process">
	<div class="container simple-process__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<!-- Список шагов -->
		<?php if (!empty($steps) && is_array($steps)): ?>
			<ul class="simple-process__list grid">
				<?php foreach ($steps as $step):
					$icon = $step['icon'] ?? null;
					$step_title = $step['title'] ?? '';
					$step_descr = $step['descr'] ?? '';
					?>
					<li class="simple-process__item steps-list-item">

						<!-- Иконка (вместо номера) -->
						<div class="steps-list-item__num">
							<?php if ($icon && is_array($icon) && !empty($icon['ID'])): ?>
								<?php echo wp_get_attachment_image(
									$icon['ID'],
									'thumbnail',
									false,
									[
										'class' => 'img',
										'alt' => $icon['alt'] ?: $step_title,
										'loading' => 'lazy',
									]
								); ?>
							<?php endif; ?>
						</div>

						<!-- Контент шага -->
						<div class="steps-list-item__content">
							<?php if ($step_title): ?>
								<h3 class="steps-list-item__title text-btn">
									<?php echo esc_html($step_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($step_descr): ?>
								<div class="steps-list-item__descr text-small descr">
									<?php echo wp_kses_post($step_descr); ?>
										</div>
								<?php endif; ?>
								</div>

						</li>
				<?php endforeach; ?>
				</ul>
		<?php endif; ?>

	</div>
</section>