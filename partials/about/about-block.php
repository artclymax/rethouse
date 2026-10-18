<?php
$label = get_field('about_block_label') ?? '';
$title = get_field('about_block_title') ?? '';
$descr = get_field('about_block_descr') ?? '';
$list_title = get_field('about_block_list_title') ?? '';
$cards = get_field('about_block_cards') ?? [];

// Если нет данных — не выводим секцию
if (!$title && !$descr && empty($cards)) {
	return;
}
?>

<section class="section about-block" id="about-block">
	<div class="container about-block__container">

		<!-- Заголовок секции -->
		<?php if ($title || $descr || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<div class="about-block__col">

			<!-- Опциональный заголовок списка -->
			<?php if ($list_title): ?>
				<h3 class="about-block__list-title title-3">
					<?php echo esc_html($list_title); ?>
				</h3>
			<?php endif; ?>

			<!-- Сетка карточек -->
			<?php if (!empty($cards) && is_array($cards)): ?>
				<ul class="about-block__cards brands-grid">
					<?php foreach ($cards as $card):
						$icon = $card['icon'] ?? null;
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';
						?>
						<li class="brands-grid-item about-block__card about-block-card">

							<!-- Иконка -->
							<?php if ($icon && is_array($icon) && !empty($icon['ID'])): ?>
								<div class="about-block-card__icon">
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

							<!-- Контент карточки -->
							<div class="about-block-card__content">
								<?php if ($card_title): ?>
									<h3 class="about-block-card__title">
										<?php echo esc_html($card_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($card_descr): ?>
									<div class="about-block-card__descr descr">
										<p><?php echo esc_html($card_descr); ?></p>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</div>
</section>