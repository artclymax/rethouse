<?php
// Получаем поля ACF
$label = get_field('resident_why_label') ?? '';
$title = get_field('resident_why_title') ?? '';
$cards = get_field('resident_why_cards') ?? [];

// Если нет данных — не выводим секцию
if (!$title && empty($cards)) {
	return;
}
?>

<section class="section resident-why" id="resident-why">
	<div class="container resident-why__container section-container">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Сетка карточек -->
		<?php if (!empty($cards) && is_array($cards)): ?>
			<ul class="resident-why__list grid">
				<?php foreach ($cards as $card):
					$icon = $card['icon'] ?? null;
					$card_title = $card['title'] ?? '';
					$card_descr = $card['descr'] ?? '';
					?>
					<li class="resident-why__item resident-why-item card-box">

						<!-- Иконка -->
						<?php if ($icon && is_array($icon) && !empty($icon['ID'])): ?>
							<div class="resident-why-item__icon">
								<?php echo wp_get_attachment_image(
									$icon['ID'],
									'thumbnail',
									false,
									[
										'class' => 'img',
										'alt' => $icon['alt'] ?: $card_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

						<!-- Заголовок -->
						<?php if ($card_title): ?>
							<h3 class="resident-why-item__title text-btn">
								<?php echo esc_html($card_title); ?>
							</h3>
						<?php endif; ?>

						<!-- Описание -->
						<?php if ($card_descr): ?>
							<div class="resident-why-item__descr text-small descr">
								<?php echo wp_kses_post($card_descr); ?>
							</div>
						<?php endif; ?>

					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>