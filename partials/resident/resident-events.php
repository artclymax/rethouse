<?php

// Инициализация переменных
$resident_id = get_the_ID();
$label = get_field('resident_events_label', $resident_id) ?? 'профессиональные направления';
$title = get_field('resident_events_title', $resident_id) ?? 'Курсы, образовательные программы и профессиональные направления от резидента';

// Запрос событий, привязанных к этому резиденту
$events_query = new WP_Query([
	'post_type' => 'education_career',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_query' => [
		[
			'key' => 'resident_brand',
			'value' => '"' . $resident_id . '"',
			'compare' => 'LIKE',
		],
	],
	'orderby' => 'date',
	'order' => 'ASC',
]);

// Проверяем, есть ли события
if ($events_query->have_posts()):
	?>
	<section class="section section-resident-events" id="resident-events">
		<div class="container section-resident-events__container section-gap">

			<!-- Шапка секции -->
			<?php if ($title): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => ''
				]); ?>
			<?php endif; ?>

			<!-- Слайдер -->
			<div class="swiper section-events__swiper events-swiper"
				data-swiper='{ "slidesPerView": 1.2, "spaceBetween": 0, "rewind": true, "breakpoints": { "768": { "slidesPerView": 2.5 }, "1024": { "slidesPerView": 3.5, "spaceBetween": 4 }, "1280": { "slidesPerView": 4, "spaceBetween": 4 } } }'>

				<div class="swiper-wrapper events-swiper__wrapper">
					<?php while ($events_query->have_posts()):
						$events_query->the_post();
						$event_id = get_the_ID();
						$event_link = get_permalink($event_id);
						$event_title = get_the_title($event_id) ?? '';
						$event_thumb_id = get_post_thumbnail_id($event_id);
						$event_date = get_field('event_start_date', $event_id) ?? '';
						$event_short_descr = get_the_excerpt($event_id) ?? '';

						// Получаем первую категорию события
						$event_cats = get_the_terms($event_id, 'event_cat');
						$event_cat_name = '';
						if (!empty($event_cats) && !is_wp_error($event_cats)) {
							$event_cat_name = $event_cats[0]->name ?? '';
						}


						// Получаем все категории курса
						$event_categories = get_the_terms($event_id, 'education_career_category');
						$event_category_names = [];
						if (!empty($event_categories) && !is_wp_error($event_categories)) {
							$event_category_names = wp_list_pluck($event_categories, 'name');
						}

						if (!$event_title)
							continue;
						?>
						<div class="swiper-slide events-swiper__slide event-card">
							<div class="event-card__wrapper">
								<a class="event-card__link card-box" href="<?php echo esc_url($event_link); ?>"
									aria-label="<?php echo esc_attr('Перейти к событию: ' . $event_title); ?>">

									<?php if ($event_thumb_id): ?>
										<div class="event-card__image image-box">
											<?php echo wp_get_attachment_image(
												(int) $event_thumb_id,
												'large',
												false,
												[
													'class' => 'img',
													'alt' => $event_title,
													'loading' => 'lazy',
												]
											); ?>
										</div>
									<?php endif; ?>

									<div class="event-card__content">
										<!-- Логотип резидента -->
										<div class="event-card__brand">
											<div class="event-card__brand-logo">
												<?php
												$post_thumb_url = get_the_post_thumbnail_url($resident_id, 'large');
												echo '<img src="' . esc_url($post_thumb_url) . '" alt="' . esc_attr(get_the_title($resident_id)) . '">'; ?>
											</div>
											<div class="event-card__brand-title text-btn">
												<?php echo esc_html(get_the_title($resident_id)); ?>
											</div>
										</div>


										<!-- Категории (вместо тегов) -->
										<?php if (!empty($event_category_names)): ?>
											<ul class="event-card__tags">
												<?php foreach ($event_category_names as $category_name): ?>
													<li class="event-card__tag badge">
														<?php echo esc_html(strtoupper($category_name)); ?>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>

										<?php if ($event_date): ?>
											<div class="event-card__date label">
												Старт <?php echo esc_html(strtoupper($event_date)); ?>
											</div>
										<?php endif; ?>

										<h3 class="event-card__title text-btn">
											<?php echo esc_html($event_title); ?>
										</h3>

										<?php if ($event_short_descr): ?>
											<div class="event-card__descr descr text-small">
												<?php echo trim_text(esc_html(mx_fix_orphans($event_short_descr)), 62); ?>
											</div>
										<?php endif; ?>
									</div>

								</a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<!-- Пагинация (только) -->
				<div class="swiper-pagination events-swiper__pagination" data-swiper-pagination=".events-swiper"></div>

			</div>
		</div>
	</section>

	<?php
	wp_reset_postdata();
endif;
?>