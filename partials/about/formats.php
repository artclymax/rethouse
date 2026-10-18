<?php

// Получаем поля ACF
$label = get_field('formats_label') ?? '';
$title = get_field('formats_title') ?? '';
$items = get_field('formats_items') ?? [];

// Если нет ни заголовка, ни элементов — не выводим секцию
if (!$title && empty($items)) {
	return;
}
?>

<section class="section formats" id="formats">
	<div class="container formats__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Сетка форматов -->
		<?php if (!empty($items) && is_array($items)): ?>
			<ul class="formats__list grid grid-mobile-2-col">
				<?php foreach ($items as $item):
					$image = $item['image'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';
					?>
					<li class="formats__item customers-card">
						<div class="customers-card__wrapper-link">

							<!-- Изображение -->
							<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
								<div class="customers-card__image image-box">
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

							<!-- Заголовок -->
							<?php if ($item_title): ?>
								<h3 class="customers-card__title text-btn">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<!-- Описание -->
							<?php if ($item_descr): ?>
								<div class="customers-card__descr descr text-small">
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