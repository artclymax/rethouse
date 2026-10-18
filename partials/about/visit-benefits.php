<?php
$label = get_field('visit_benefits_label') ?? '';
$title = get_field('visit_benefits_title') ?? '';
$items = get_field('visit_benefits_items') ?? [];

// Если нет ни заголовка, ни элементов — не выводим секцию
if (!$title && empty($items)) {
	return;
}
?>

<section class="section visit-benefits" id="visit-benefits">
	<div class="container visit-benefits__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Список преимуществ -->
		<?php if (!empty($items) && is_array($items)): ?>
			<ul class="visit-benefits__list grid">
				<?php foreach ($items as $item):
					$image = $item['image'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';
					?>
					<li class="visit-benefits__item visit-benefits-item">

						<!-- Изображение -->
						<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
							<div class="visit-benefits-item__image image-box">
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

						<!-- Контент -->
						<div class="visit-benefits-item__content">
							<?php if ($item_title): ?>
								<h3 class="visit-benefits-item__title text-btn">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="visit-benefits-item__descr descr text-small">
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