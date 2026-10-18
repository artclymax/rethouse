<?php

$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF
$label = get_field('partnership_label', $page_id) ?? '';
$title = get_field('partnership_title', $page_id) ?? '';
$descr = get_field('partnership_descr', $page_id) ?? '';
$cards = get_field('partnership_cards', $page_id) ?? [];

// Если нет ни заголовка, ни карточек — не выводим секцию
if (!$title && empty($cards)) {
	return;
}
?>

<section class="section section-partnership" id="section-partnership">
	<div class="container section-partnership__container section-gap">

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
			<ul class="section-partnership__list grid">
				<?php foreach ($cards as $card):
					$card_label = $card['label'] ?? '';
					$card_title = $card['title'] ?? '';
					$card_descr = $card['descr'] ?? '';
					$card_btn = $card['btn'] ?? null;
					$card_image = $card['image'] ?? null;
					?>
					<li class="section-partnership__item partnership-card">

						<!-- Изображение -->
						<?php if ($card_image && is_array($card_image) && !empty($card_image['ID'])): ?>
							<div class="partnership-card__image image-box">
								<?php echo wp_get_attachment_image(
									$card_image['ID'],
									'medium_large',
									false,
									[
										'class' => 'img',
										'alt' => $card_image['alt'] ?: $card_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

						<!-- Контент карточки -->
						<div class="partnership-card__content">

							<!-- Метка -->
							<?php if ($card_label): ?>
								<p class="partnership-card__label label">
									<?php echo esc_html($card_label); ?>
								</p>
							<?php endif; ?>

							<!-- Заголовок -->
							<?php if ($card_title): ?>
								<h3 class="partnership-card__title title-3">
									<?php echo esc_html($card_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($card_descr): ?>
								<div class="partnership-card__descr descr descr-list">
									<?php echo wp_kses_post($card_descr); ?>
								</div>
							<?php endif; ?>

							<!-- Кнопка -->
							<?php if ($card_btn && !empty($card_btn['url'])): ?>
								<a class="partnership-card__btn btn" href="<?php echo esc_url($card_btn['url']); ?>" <?php if (!empty($card_btn['target'])): ?>target="
						<?php echo esc_attr($card_btn['target']); ?>"
									<?php endif; ?>>
									<?php echo esc_html($card_btn['title']); ?>
								</a>
							<?php endif; ?>

						</div>

					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>