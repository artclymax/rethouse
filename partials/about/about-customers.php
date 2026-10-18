<?php
$label = get_field('customers_label') ?? '';
$title = get_field('customers_title') ?? '';
$cards = get_field('customers_cards') ?? [];

// Если нет данных — не выводим секцию
if (!$title && empty($cards)) {
	return;
}
?>

<section class="section customers" id="customers">
	<div class="container customers__container">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Сетка карточек -->
		<?php if (!empty($cards) && is_array($cards)): ?>
			<ul class="customers__cards grid">
				<?php foreach ($cards as $card):
					$image = $card['image'] ?? null;
					$card_title = $card['title'] ?? '';
					$card_descr = $card['descr'] ?? '';
					$card_link = $card['link'] ?? null;

					// Определяем URL ссылки
					$link_url = '';
					$link_target = '';
					if ($card_link && !empty($card_link['url'])) {
						$link_url = $card_link['url'];
						$link_target = !empty($card_link['target']) ? $card_link['target'] : '_self';
					}
					?>
					<li class="customers__card customers-card">
						<?php if ($link_url): ?>
							<a class="customers-card__wrapper-link" href="<?php echo esc_url($link_url); ?>" <?php if ($link_target !== '_self'): ?>target="
					<?php echo esc_attr($link_target); ?>" <?php endif; ?>>
							<?php else: ?>
								<div class="customers-card__wrapper-link">
								<?php endif; ?>

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

								<!-- Заголовок (с поддержкой <br>) -->
								<?php if ($card_title): ?>
									<h3 class="customers-card__title title-3 descr">
										<?php echo wp_kses_post($card_title); ?>
									</h3>
								<?php endif; ?>

								<!-- Описание -->
								<?php if ($card_descr): ?>
									<div class="customers-card__descr descr">
										<?php echo esc_html($card_descr); ?>
									</div>
								<?php endif; ?>

								<!-- Кнопка "Подробнее" -->
								<?php if ($link_url): ?>
									<span class="customers-card__btn link-arrow">
										Подробнее
									</span>
								<?php endif; ?>
								<?php if ($link_url): ?>
							</a>
						<?php else: ?>
				</div>
			<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	</div>
</section>