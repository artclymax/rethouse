<?php
$label = get_field('consultation_label') ?? '';
$title = get_field('consultation_title') ?? '';
$image = get_field('consultation_image') ?? null;
$cards = get_field('consultation_cards') ?? [];

// Если нет ни заголовка, ни карточек, ни фона — не выводим секцию
if (!$title && empty($cards) && !$image) {
	return;
}
?>

<section class="section-full consultation-included jarallax" id="consultation-included">
	<div class="container consultation-included__container">
		<div class="consultation-included__wrapper section-gap card-box">

			<!-- Заголовок секции -->
			<?php if ($title || $label): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
				]); ?>
			<?php endif; ?>

			<!-- Список карточек -->
			<?php if (!empty($cards) && is_array($cards)): ?>
				<ul class="consultation-included__list grid">
					<?php foreach ($cards as $card):
						$icon = $card['icon'] ?? null;
						$card_title = $card['title'] ?? '';
						?>
						<li class="consultation-included__item consultation-included-card">

							<!-- Иконка -->
							<?php if ($icon && is_array($icon) && !empty($icon['ID'])): ?>
								<div class="consultation-included-card__icon">
									<?php echo wp_get_attachment_image(
										$icon['ID'],
										'large',
										false,
										[
											'class' => 'img',
											'alt' => $icon['alt'] ?: $card_title,
											'loading' => 'lazy',
										]
									); ?>
								</div>
							<?php endif; ?>

							<!-- Заголовок карточки -->
							<?php if ($card_title): ?>
								<h3 class="consultation-included-card__title text-btn">
									<?php echo esc_html($card_title); ?>
								</h3>
							<?php endif; ?>

						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</div>

	<!-- Фоновое изображение для Jarallax -->
	<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
		<div class="consultation-included__image image-box jarallax-img">
			<?php echo wp_get_attachment_image(
				$image['ID'],
				'large',
				false,
				[
					'class' => 'img',
					'alt' => $image['alt'] ?: ($title ?: 'Консультация'),
				]
			); ?>
		</div>
	<?php endif; ?>

</section>