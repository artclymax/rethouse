<?php
/**
 * Template Part: All Courses Section
 * Description: Секция всех курсов и мероприятий с поддержкой нескольких категорий и выводом привязанного резидента
 */

// Получаем поля ACF секции (можно брать с текущей страницы или с опций)
$page_id = $args['page_id'] ?? get_the_ID();
$label = get_field('courses_section_label', $page_id) ?? 'Курсы и программы от партнёров';
$title = get_field('courses_section_title', $page_id) ?? 'Школы дизайна и смежные направления';
$descr = get_field('courses_section_descr', $page_id) ?? 'Курсы, образовательные программы и профессиональные направления от резидентов и партнёров RET HOUSE.';

// Запрос ВСЕХ записей образования/карьеры
$events_query = new WP_Query([
	'post_type' => 'education_career',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'ASC',
]);

// Если записей нет — не выводим секцию
if (!$events_query->have_posts()) {
	wp_reset_postdata();
	return;
}

// ДИНАМИЧЕСКИЙ СБОР ВСЕХ УНИКАЛЬНЫХ КАТЕГОРИЙ ДЛЯ ТАБОВ
$categories_for_tabs = [];
$temp_query = clone $events_query;
while ($temp_query->have_posts()) {
	$temp_query->the_post();
	$terms = get_the_terms(get_the_ID(), 'education_career_category');
	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			$categories_for_tabs[$term->slug] = $term->name;
		}
	}
}
wp_reset_postdata();
?>

<section class="section courses" id="courses">
	<div class="container courses__container">

		<!-- Заголовок секции -->
		<?php get_template_part('partials/section-header', null, [
			'label' => $label,
			'title' => $title,
			'descr' => $descr,
		]); ?>

		<!-- Динамические табы -->
		<?php if (!empty($categories_for_tabs)): ?>
			<ul class="courses__tabs courses-tabs">
				<li class="courses-tabs__item">
					<button class="courses-tabs__btn active" type="button" data-courses-tab="all">
						Все направления
					</button>
				</li>
				<?php foreach ($categories_for_tabs as $slug => $name): ?>
					<li class="courses-tabs__item">
						<button class="courses-tabs__btn" type="button" data-courses-tab="<?php echo esc_attr($slug); ?>">
							<?php echo esc_html($name); ?>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="courses__slider">
			<!-- Карусель Swiper -->
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

						// 1. ПОЛУЧАЕМ ВСЕ КАТЕГОРИИ ДЛЯ ФИЛЬТРАЦИИ (через пробел)
						$event_cats = get_the_terms($event_id, 'education_career_category');
						$event_cat_slugs = [];
						if (!empty($event_cats) && !is_wp_error($event_cats)) {
							foreach ($event_cats as $cat) {
								$event_cat_slugs[] = $cat->slug;
							}
						}
						// Формируем строку: "slug1 slug2 slug3" или "all"
						$data_categories_attr = !empty($event_cat_slugs) ? implode(' ', $event_cat_slugs) : 'all';

						// Теги/материалы
					
						// Получаем все категории курса
						$event_categories = get_the_terms($event_id, 'education_career_category');
						$event_category_names = [];
						if (!empty($event_categories) && !is_wp_error($event_categories)) {
							$event_category_names = wp_list_pluck($event_categories, 'name');
						}

						// 2. ПОЛУЧАЕМ ДАННЫЕ ПРИВЯЗАННОГО РЕЗИДЕНТА
						$linked_resident = get_field('resident_brand', $event_id); // ACF Post Object или Relationship
						$resident_title = '';
						$resident_logo_url = '';

						if ($linked_resident) {
							// Приводим к массиву, если это Relationship field, или оставляем как есть, если Post Object
							$resident_post = is_array($linked_resident) ? $linked_resident[0] : $linked_resident;

							if (is_object($resident_post) && isset($resident_post->ID)) {
								$resident_title = get_the_title($resident_post->ID);
								$resident_logo_url = get_the_post_thumbnail_url($resident_post->ID, 'thumbnail');
							} elseif (is_numeric($linked_resident)) { // Если ACF возвращает просто ID
								$resident_title = get_the_title($linked_resident);
								$resident_logo_url = get_the_post_thumbnail_url($linked_resident, 'thumbnail');
							}
						}

						if (!$event_title)
							continue;
						?>
						<div class="swiper-slide events-swiper__slide event-card"
							data-category="<?php echo esc_attr($data_categories_attr); ?>">
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
										<!-- Логотип и название привязанного резидента -->
										<div class="event-card__brand">
											<div class="event-card__brand-logo">
												<?php if ($resident_logo_url): ?>
													<img src="<?php echo esc_url($resident_logo_url); ?>"
														alt="<?php echo esc_attr($resident_title); ?>">
												<?php endif; ?>
											</div>
											<div class="event-card__brand-title text-btn">
												<?php echo esc_html($resident_title ?: 'Партнёр'); ?>
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

										<!-- Дата -->
										<?php if ($event_date): ?>
											<div class="event-card__date label">
												Старт <?php echo esc_html(strtoupper($event_date)); ?>
											</div>
										<?php endif; ?>

										<!-- Заголовок -->
										<h3 class="event-card__title text-btn">
											<?php echo esc_html($event_title); ?>
										</h3>

										<!-- Описание -->
										<?php if ($event_short_descr): ?>
											<div class="event-card__descr descr text-small">
												<?php
												if (function_exists('trim_text') && function_exists('mx_fix_orphans')) {
													echo trim_text(esc_html(mx_fix_orphans($event_short_descr)), 62);
												} else {
													echo wp_kses_post(wp_trim_words($event_short_descr, 15, '...'));
												}
												?>
											</div>
										<?php endif; ?>
									</div>
									<span class="event-card__btn link-arrow">
										Подробнее
									</span>
								</a>
							</div>
						</div>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</div>

				<!-- Пагинация Swiper -->
				<div class="swiper-pagination events-swiper__pagination" data-swiper-pagination=".events-swiper"></div>
			</div>
			<button class="swiper-btn swiper-btn__prev events-swiper__btn events-swiper__prev hidden-mobile"
				data-swiper-btn-prev=".events-swiper" aria-label="Назад"></button>
			<button class="swiper-btn swiper-btn__next events-swiper__btn events-swiper__next hidden-mobile"
				data-swiper-btn-next=".events-swiper" aria-label="Вперёд"></button>
		</div>
	</div>
</section>