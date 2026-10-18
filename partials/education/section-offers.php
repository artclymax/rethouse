<?php
$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF
$label = get_field('section_offers_label', $page_id) ?? '';
$title = get_field('section_offers_title', $page_id) ?? '';
$items = get_field('section_offers_items', $page_id) ?? [];

// Если нет ни заголовка, ни элементов — не выводим секцию
if (!$title && empty($items)) {
	return;
}
?>

<section class="section section-offers" id="section-offers">
	<div class="container section-offers__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Список карточек -->
		<?php if (!empty($items) && is_array($items)): ?>
			<ul class="section-offers__list grid">
				<?php foreach ($items as $item):
					$icon = $item['icon'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';
					?>
					<li class="section-offers__item offers-item">

						<!-- Иконка -->
						<?php if ($icon && is_array($icon) && !empty($icon['ID'])): ?>
							<div class="offers-item__icon">
								<?php echo wp_get_attachment_image(
									$icon['ID'],
									'thumbnail',
									false,
									[
										'class' => 'img',
										'alt' => $icon['alt'] ?: $item_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

						<!-- Контент карточки -->
						<div class="offers-item__content">
							<?php if ($item_title): ?>
								<h3 class="offers-item__title title-3">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="offers-item__descr descr text-small">
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