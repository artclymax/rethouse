<?php
$page_id = $args['page_id'] ?? get_the_ID();
$current_post_id = get_the_ID();

$label = get_field('section_events_label', $page_id) ?? 'Смотрите также';
$title = get_field('section_events_title', $page_id) ?? 'Другие мероприятия';
$descr = get_field('section_events_descr', $page_id) ?? '';
$btn = get_field('section_events_btn', $page_id) ?? [];
$events_repeater = get_field('section_events_list', $page_id) ?? [];

// 1. Формируем массив событий из repeater
$events = [];
if (!empty($events_repeater)) {
	foreach ($events_repeater as $item) {
		$event = $item['event'] ?? null;
		if ($event && is_object($event) && isset($event->ID)) {

			if ($event->ID != $current_post_id) {
				$events[] = $event;
			}
		}
	}
}

// 2. Если массив пуст — делаем резервный запрос, ИСКЛЮЧАЯ текущий пост
if (empty($events)) {
	$default_args = [
		'post_type' => 'events',
		'posts_per_page' => 4,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'post__not_in' => [$current_post_id],
	];

	$default_query = new WP_Query($default_args);
	if ($default_query && $default_query->have_posts()) {
		while ($default_query->have_posts()) {
			$default_query->the_post();
			$events[] = get_post();
		}
		wp_reset_postdata();
	}
}

// Защитная обёртка
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));
$has_events = !empty($events);

if ($has_content || $has_events):
	?>
	<section class="section section-events" id="events">
		<div class="container section-events__container">

			<!-- Шапка секции + кнопка -->
			<?php if ($has_content): ?>
				<div class="section-events__header header-row">
					<div class="header-row__content">
						<?php get_template_part('partials/section-header', null, [
							'label' => $label,
							'title' => $title,
							'descr' => $descr
						]); ?>
					</div>

					<?php if (!empty($btn) && !empty($btn['url'])): ?>
						<a class="header-row__btn btn btn--stroke btn--stroke-gray" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
				<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title']); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Слайдер -->
			<?php if ($has_events): ?>
				<div class="swiper section-events__swiper events-swiper"
					data-swiper='{ "slidesPerView": 1.2, "spaceBetween": 0, "rewind": true, "breakpoints": {  "768": { "slidesPerView": 2.5 }, "1024": { "slidesPerView": 3.5, "spaceBetween": 4 }, "1280": { "slidesPerView": 4, "spaceBetween": 4 } } }'>
					<div class="swiper-wrapper events-swiper__wrapper">
						<?php foreach ($events as $event):
							$event_id = $event->ID;
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
										<?php if ($event_date): ?>
											<div class="event-card__date label">
												Старт
												<?php echo esc_html(strtoupper($event_date)); ?>
											</div>
										<?php endif; ?>

										<?php if ($event_cats): ?>
											<div class="event-card__badge-list">
												<?php foreach ($event_cats as $event_cat): ?>
													<span class="event-card__badge badge">
														<?php echo esc_html(strtoupper($event_cat->name)); ?>
													</span>
												<?php endforeach; ?>
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
									</a>
								</div>

							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		</div>
	</section>
<?php endif; ?>