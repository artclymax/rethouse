<?php
/**
 * Template: Section Consult
 * Description: Секция консультации (Изображение + Список преимуществ + Мета-данные)
 */

// Инициализация переменных
$page = get_queried_object();
$label = get_field('consult_label', $page) ?? '';
$title = get_field('consult_title', $page) ?? '';
$descr = get_field('consult_descr', $page) ?? '';
$features = get_field('consult_features', $page) ?? [];
$meta_format = get_field('consult_meta_format', $page) ?? '';
$meta_duration = get_field('consult_meta_duration', $page) ?? '';
$btn = get_field('consult_btn', $page) ?? [];
$image = get_field('consult_image', $page) ?? null;

// Защитная обёртка
$has_content = ($title || $descr || !empty($features) || $meta_format || $meta_duration || (!empty($btn) && !empty($btn['url'])));
$has_image = ($image && is_array($image) && !empty($image['ID']));

if ($has_content || $has_image):
	?>
	<section class="section consult-section" id="consult">
		<div class="container consult-section__container">

			<!-- Левая колонка: Изображение -->
			<?php if ($has_image): ?>
				<div class="consult-section__image image-box jarallax">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img jarallax-img',
							'alt' => $image['alt'] ?: $title,
							'loading' => 'lazy'
						]
					); ?>
				</div>
			<?php endif; ?>

			<!-- Правая колонка: Контент -->
			<?php if ($has_content): ?>
				<div class="consult-section__content">
					<div class="consult-section__inner">
						<?php get_template_part('partials/section-header', null, [
							'label' => $label,
							'title' => $title,
							'descr' => $descr
						]); ?>

						<?php if (!empty($features)): ?>
							<ul class="consult-section__list check-list">
								<?php foreach ($features as $item):
									$item_text = $item['feature_text'] ?? '';
									if (!$item_text)
										continue;
									?>
									<li class="check-list__item">
										<?php echo esc_html($item_text); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ($meta_format || $meta_duration): ?>
							<div class="consult-section__meta meta-row">
								<?php if ($meta_format): ?>
									<div class="meta-row__item meta-item">
										<span class="meta-item__text text-small icon icon--address">
											<?php echo esc_html($meta_format); ?>
										</span>
									</div>
								<?php endif; ?>

								<?php if ($meta_duration): ?>
									<div class="meta-row__item meta-item">
										<span class="meta-item__text text-small icon icon--time">
											<?php echo esc_html($meta_duration); ?>
										</span>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					<?php if (!empty($btn) && !empty($btn['url'])): ?>
						<a class="consult-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
					<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title']); ?>
						</a>
					<?php endif; ?>

				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>