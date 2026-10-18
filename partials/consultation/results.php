<?php
$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF
$label = get_field('results_label', $page_id) ?? '';
$title = get_field('results_title', $page_id) ?? '';
$descr = get_field('results_descr', $page_id) ?? '';
$items = get_field('results_items', $page_id) ?? [];

// Если нет ни заголовка, ни элементов — не выводим секцию
if (!$title && empty($items)) {
	return;
}
?>

<section class="section results" id="results">
	<div class="container results__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $descr || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<!-- Список карточек -->
		<?php if (!empty($items) && is_array($items)): ?>
			<ul class="results__list">
				<?php foreach ($items as $item):
					$image = $item['image'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';

					// Проверяем, есть ли валидное изображение
					$has_image = $image && is_array($image) && !empty($image['ID']);

					// Формируем классы карточки (как в React-компоненте)
					$card_classes = ['results__item', 'results-card'];
					if ($has_image) {
						$card_classes[] = 'results-card--image';
					}
					?>
					<li class="<?php echo esc_attr(implode(' ', $card_classes)); ?>">

						<!-- Изображение (только если загружено) -->
						<?php if ($has_image): ?>
							<div class="results-card__image image-box">
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'medium_large',
									false,
									[
										'class' => 'img',
										'alt' => $image['alt'] ?: $item_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

						<!-- Контент карточки -->
						<div class="results-card__content">
							<?php if ($item_title): ?>
								<h3 class="results-card__title text-btn">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="results-card__descr descr text-small">
									<?php echo wp_kses_post($item_descr); ?>
								</div>
							<?php endif; ?>
						</div>

					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>