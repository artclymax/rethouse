<?php

// Инициализация переменных
$page = get_queried_object();
$label = get_field('about_block_label', $page) ?? '';
$title = get_field('about_block_title', $page) ?? '';
$descr = get_field('about_block_descr', $page) ?? '';
$list_title = get_field('about_block_list_title', $page) ?? '';
$cards = get_field('about_block_cards', $page) ?? [];

// Защитная обёртка
$has_content = ($title || $descr || $list_title || !empty($cards));

if ($has_content):
	?>
	<section class="section about-block" id="about-block">
		<div class="container about-block__container">

			<!-- Шапка секции -->
			<?php if ($title || $descr): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
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
				<?php if (!empty($cards)): ?>
					<ul class="about-block__cards brands-grid">
						<?php foreach ($cards as $card):
							$card_icon = $card['icon'] ?? null;
							$card_title = $card['title'] ?? '';
							$card_descr = $card['descr'] ?? '';

							// Пропускаем полностью пустые карточки
							if (!$card_title && !$card_descr)
								continue;
							?>
							<li class="brands-grid-item about-block__card about-block-card">

								<?php if ($card_icon && is_array($card_icon) && !empty($card_icon['ID'])): ?>
									<div class="about-block-card__icon">
										<?php echo wp_get_attachment_image(
											$card_icon['ID'],
											'medium',
											false,
											[
												'class' => 'img',
												'alt' => $card_icon['alt'] ?: $card_title,
												'loading' => 'lazy'
											]
										); ?>
									</div>
								<?php endif; ?>

								<div class="about-block-card__content">
									<?php if ($card_title): ?>
										<h3 class="about-block-card__title">
											<?php echo esc_html($card_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($card_descr): ?>
										<div class="about-block-card__descr descr">
											<?php echo wp_kses_post($card_descr); ?>
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
<?php endif; ?>