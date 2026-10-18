<?php
$label = get_field('why_label') ?? '';
$title = get_field('why_title') ?? '';
$descr = get_field('why_descr') ?? '';
$cards = get_field('why_cards') ?? [];

// Если нет данных — не выводим секцию
if (!$title && empty($cards)) {
	return;
}
?>

<section class="section resident-why-it-works" id="resident-why-it-works">
	<div class="container resident-why-it-works__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $descr || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<!-- Список карточек -->
		<?php if (!empty($cards) && is_array($cards)): ?>
			<ul class="resident-why-it-works__list grid">
				<?php foreach ($cards as $card):
					$image = $card['image'] ?? null;
					$card_title = $card['title'] ?? '';
					$is_positive = !empty($card['is_positive']);
					$items = $card['items'] ?? [];

					// Класс карточки в зависимости от типа
					$card_class = $is_positive ? 'positive-list' : 'negative-list';
					?>
					<li
						class="<?php echo esc_attr($card_class); ?> resident-why-it-works__item resident-why-it-works-item card-box">

						<!-- Изображение -->
						<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
							<div class="resident-why-it-works-item__image image-box">
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'medium_large',
									false,
									[
										'class' => 'img',
										'alt' => $image['alt'] ?: $card_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

						<!-- Контент -->
						<div class="resident-why-it-works-item__content">

							<!-- Заголовок -->
							<?php if ($card_title): ?>
								<h3 class="resident-why-it-works-item__title title-3">
									<?php echo esc_html($card_title); ?>
								</h3>
							<?php endif; ?>

							<!-- Список пунктов -->
							<?php if (!empty($items) && is_array($items)): ?>
								<div class="resident-why-it-works-item__descr text-small descr">
									<ul>
										<?php foreach ($items as $item):
											$item_text = $item['text'] ?? '';
											if (!$item_text)
												continue;
											?>
											<li><?php echo esc_html($item_text); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>