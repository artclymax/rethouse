<?php

$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF секции
$label = get_field('experts_label', $page_id) ?? '';
$title = get_field('experts_title', $page_id) ?? '';
$limit = get_field('experts_limit', $page_id) ?? -1;
$limit = intval($limit);

// Запрашиваем записи типа expert
$experts_query = new WP_Query([
	'post_type' => 'expert',
	'post_status' => 'publish',
	'posts_per_page' => $limit > 0 ? $limit : -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'no_found_rows' => true,
]);

// Если нет ни заголовка, ни записей — не выводим секцию
if (!$title && !$experts_query->have_posts()) {
	wp_reset_postdata();
	return;
}
?>

<section class="section section-experts" id="section-experts">
	<div class="container section-experts__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>
		<?php endif; ?>

		<!-- Карусель экспертов -->
		<?php if ($experts_query->have_posts()): ?>
			<div class="section-experts__slider">
				<div class="swiper experts-swiper"
					data-swiper="{'slidesPerView': 1, 'spaceBetween': 20, 'rewind': true, 'breakpoints': { '768': { 'slidesPerView': 2, 'spaceBetween': 20 }, '1024': { 'slidesPerView': 3, 'spaceBetween': 24 }}}">

					<div class="swiper-wrapper experts-swiper__wrapper">
						<?php while ($experts_query->have_posts()):
							$experts_query->the_post();
							$expert_id = get_the_ID();
							$expert_name = get_the_title();
							$expert_position = apply_filters('the_content', get_the_content()) ?? '';
							$has_thumb = has_post_thumbnail($expert_id);
							?>
							<div class="swiper-slide experts-swiper__slide visit-benefits__item visit-benefits-item">

								<!-- Фото эксперта -->
								<?php if ($has_thumb): ?>
									<div class="visit-benefits-item__image image-box">
										<?php the_post_thumbnail('medium_large', [
											'class' => 'img',
											'alt' => $expert_name,
											'loading' => 'lazy',
										]); ?>
									</div>
								<?php endif; ?>

								<!-- Контент -->
								<div class="visit-benefits-item__content">
									<h3 class="visit-benefits-item__title title-3">
										<?php echo esc_html($expert_name); ?>
									</h3>
									<?php if ($expert_position): ?>
										<div class="visit-benefits-item__descr descr text-small">
											<?php echo wp_kses_post($expert_position); ?>
										</div>
									<?php endif; ?>
								</div>

							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>

					<!-- Пагинация (мобильная) -->
					<div class="swiper-pagination experts-swiper__pagination visible-mobile"
						data-swiper-pagination=".experts-swiper"></div>
				</div>

				<!-- Кнопки навигации (десктоп) -->
				<button class="swiper-btn swiper-btn__prev experts-swiper__btn experts-swiper__prev hidden-mobile"
					data-swiper-btn-prev=".experts-swiper" aria-label="Назад"></button>
				<button class="swiper-btn swiper-btn__next experts-swiper__btn experts-swiper__next hidden-mobile"
					data-swiper-btn-next=".experts-swiper" aria-label="Вперёд"></button>
			</div>
		<?php endif; ?>

	</div>
</section>