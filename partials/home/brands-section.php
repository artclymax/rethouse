<?php
/**
 * Template: Section Brands (Residents)
 * Description: Сетка резидентов/брендов (логотип из миниатюры + название + краткое описание из отрывка)
 */

// Инициализация переменных из ACF
$page = get_queried_object();
$label = get_field('section_brands_label', $page) ?? '';
$title = get_field('section_brands_title', $page) ?? '';
$descr = get_field('section_brands_descr', $page) ?? '';
$btn = get_field('section_brands_btn', $page) ?? [];
$btn_second = get_field('section_brands_btn_second', $page) ?? [];
$brands_repeater = get_field('section_brands_list', $page) ?? [];

// Формируем массив резидентов из repeater
$brands = [];
if (!empty($brands_repeater)) {
	foreach ($brands_repeater as $item) {
		$brand = $item['brand'] ?? null;

		// Проверяем, что это объект поста и его тип - resident
		if ($brand && is_a($brand, 'WP_Post') && $brand->post_type === 'resident') {
			$brands[] = $brand;
		}
	}
}

// Если в repeater ничего не выбрано — берем последние 9 опубликованных резидентов
if (empty($brands)) {
	$default_args = [
		'post_type' => 'resident',
		'post_status' => 'publish',
		'posts_per_page' => 9,
		'orderby' => 'date',
		'order' => 'DESC',
	];
	$brands = get_posts($default_args);
}

// Защитная обёртка: показываем секцию, если есть контент ИЛИ есть резиденты
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])) || (!empty($btn_second) && !empty($btn_second['url'])));
$has_brands = !empty($brands);

if ($has_content || $has_brands):
	?>
	<section class="section brands-section" id="brands">
		<div class="container brands-section__container section-grid">

			<!-- Левая часть: контент -->
			<?php if ($has_content): ?>
				<div class="brands-section__content">
					<?php get_template_part('partials/section-header', null, [
						'label' => $label,
						'title' => $title,
						'descr' => $descr
					]); ?>

					<div class="brands-section__btn-box">
						<?php if (!empty($btn) && !empty($btn['url'])): ?>
							<a class="brands-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn['title']); ?>
							</a>
						<?php endif; ?>

						<?php if (!empty($btn_second) && !empty($btn_second['url'])): ?>
							<a class="brands-section__btn btn btn--stroke btn--stroke-gray"
								href="<?php echo esc_url($btn_second['url']); ?>" <?php if (!empty($btn_second['target'])): ?>target="<?php echo esc_attr($btn_second['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn_second['title']); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Правая часть: сетка резидентов -->
			<?php if ($has_brands): ?>
				<ul class="brands-section__grid grid">
					<?php foreach ($brands as $brand):
						$brand_id = (int) $brand->ID;
						$brand_link = get_permalink($brand_id);
						$brand_name = $brand->post_title ?? '';

						// Получаем краткое описание (отрывок) поста
						$brand_descr = get_the_excerpt($brand_id);

						if (!$brand_name) {
							continue;
						}
						?>
						<li class="brands-section__card brands-card">
							<a class="brands-card__link-wrapper" href="<?php echo esc_url($brand_link); ?>"
								aria-label="<?php echo esc_attr('Перейти к резиденту: ' . $brand_name); ?>">

								<!-- Логотип: стандартная миниатюра записи (Thumbnail) -->
								<?php if (has_post_thumbnail($brand_id)): ?>
									<div class="brands-card__logo image-box">
										<?php echo get_the_post_thumbnail(
											$brand_id,
											'large', // Или ваш размер, например 'medium' или 'thumbnail'
											[
												'class' => 'img',
												'alt' => esc_attr($brand_name),
												'loading' => 'lazy',
											]
										); ?>
									</div>
								<?php endif; ?>

								<div class="brands-card__content">
									<h3 class="brands-card__title text-btn">
										<?php echo esc_html($brand_name); ?>
									</h3>

									<?php if ($brand_descr): ?>
										<div class="brands-card__descr descr text-small">
											<?php echo esc_html($brand_descr); ?>
										</div>
									<?php endif; ?>
								</div>

							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>