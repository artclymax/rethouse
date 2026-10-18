<?php
// Получаем поля ACF
$label = get_field('resident_format_label') ?? '';
$title = get_field('resident_format_title') ?? '';
$descr = get_field('resident_format_descr') ?? '';
$cards = get_field('resident_format_cards') ?? [];

// Если нет данных — не выводим секцию
if (!$title && empty($cards)) {
	return;
}
?>

<section class="section resident-format" id="resident-format">
	<div class="container resident-format__container section-container">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<!-- Сетка карточек -->
		<?php if (!empty($cards) && is_array($cards)): ?>
			<ul class="resident-format__list customers__cards grid">
				<?php foreach ($cards as $card):
					$image = $card['image'] ?? null;
					$card_title = $card['title'] ?? '';
					$card_descr = $card['descr'] ?? '';
					?>
					<li class="customers__card customers-card">
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
											'alt' => $image['alt'] ?: $card_title,
											'loading' => 'lazy',
										]
									); ?>
								</div>
							<?php endif; ?>

							<?php if ($card_title): ?>
								<h3 class="customers-card__title title-3 descr">
									<?php echo wp_kses_post($card_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($card_descr): ?>
								<div class="customers-card__descr descr">
									<?php echo esc_html($card_descr); ?>
								</div>
							<?php endif; ?>

						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>