<?php
// Получаем поля ACF
$label = get_field('for_whom_label') ?? '';
$title = get_field('for_whom_title') ?? '';
$steps = get_field('for_whom_steps') ?? [];

// Если нет данных — не выводим секцию
if (!$title && empty($steps)) {
	return;
}
?>

<section class="section for-whom" id="for-whom">
	<div class="container for-whom__container">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>

			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Вертикальный список шагов -->
		<?php if (!empty($steps) && is_array($steps)): ?>
			<ul class="for-whom__list steps-list steps-list--vertical">
				<?php foreach ($steps as $step):
					$step_title = $step['title'] ?? '';
					$step_descr = $step['descr'] ?? '';
					?>
					<li class="for-whom__item steps-list__item">
						<div class="steps-list__num"></div>
						<div class="steps-list__content">
							<?php if ($step_title): ?>
								<h3 class="steps-list__title text-btn">
									<?php echo esc_html($step_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($step_descr): ?>
								<div class="steps-list__descr text-small descr">
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