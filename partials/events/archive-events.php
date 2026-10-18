<?php

// ==================== НАСТРОЙКИ ЗАПРОСА ====================
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 12;

$current_category = isset($_GET['event_cat']) ? sanitize_text_field($_GET['event_cat']) : '';
$search_query = isset($_GET['event_search']) ? sanitize_text_field($_GET['event_search']) : '';
$current_sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'default';

// ==================== КАТЕГОРИИ ====================
$event_categories = get_terms([
	'taxonomy' => 'event_cat',
	'hide_empty' => false,
]);

// ==================== ЗАПРОС ОБЫЧНЫХ СОБЫТИЙ ====================
$events_args = [
	'post_type' => 'events',
	'post_status' => 'publish',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
];

if (!empty($featured_ids)) {
	$events_args['post__not_in'] = $featured_ids;
}

if ($current_category) {
	$events_args['tax_query'] = [
		['taxonomy' => 'event_cat', 'field' => 'slug', 'terms' => $current_category],
	];
}

if ($search_query) {
	$events_args['s'] = $search_query;
}

// Сортировка
$events_args['orderby'] = 'date';
$events_args['order'] = 'DESC';

if ($current_sort === 'title_asc') {
	$events_args['orderby'] = 'title';
	$events_args['order'] = 'ASC';
} elseif ($current_sort === 'title_desc') {
	$events_args['orderby'] = 'title';
	$events_args['order'] = 'DESC';
} elseif ($current_sort === 'date_asc') {
	$events_args['orderby'] = 'date';
	$events_args['order'] = 'ASC';
} elseif ($current_sort === 'date_desc') {
	$events_args['orderby'] = 'date';
	$events_args['order'] = 'DESC';
}

$events_query = new WP_Query($events_args);


?>
<section class="events-archive" id="events-archive">
	<div class="container events-archive__container">
		<?php if ($events_query->have_posts()): ?>
			<ul class="events-archive__list events-grid grid">
				<?php while ($events_query->have_posts()):
					$events_query->the_post();
					$event_id = get_the_ID();
					$event_link = get_permalink($event_id);
					$event_title = get_the_title();
					$event_thumb = get_the_post_thumbnail_url($event_id, 'large');
					$event_date = get_field('event_start_date', $event_id);
					$event_excerpt = get_the_excerpt();

					$event_cats = get_the_terms($event_id, 'event_cat');
					$event_cat_name = '';
					if ($event_cats && !is_wp_error($event_cats)) {
						$event_cat_name = $event_cats[0]->name;
					}
					?>
					<li class="event-card">
						<div class="event-card__wrapper">
							<a class="event-card__link card-box" href="<?php echo esc_url($event_link); ?>">

								<?php if ($event_thumb): ?>
									<div class="event-card__image image-box">
										<img src="<?php echo esc_url($event_thumb); ?>" alt="<?php echo esc_attr($event_title); ?>"
											class="img" loading="lazy">
									</div>
								<?php endif; ?>

								<?php if ($event_date): ?>
									<div class="event-card__date label">
										Старт
										<?php echo esc_html(strtoupper($event_date)); ?>
									</div>
								<?php endif; ?>

								<?php if ($event_cats): ?>
									<div class="event-card__badge">
										<?php foreach ($event_cats as $event_cat): ?>
											<span class="event-card__badge badge">
												<?php echo esc_html($event_cat->name); ?>
											</span>
										<?php endforeach; ?>

									</div>

								<?php endif; ?>

								<h3 class="event-card__title text-btn">
									<?php echo esc_html($event_title); ?>
								</h3>

								<?php if ($event_excerpt): ?>
									<div class="event-card__descr descr text-small">
										<?php echo wp_kses_post(wp_trim_words($event_excerpt, 15, '...')); ?>
									</div>
								<?php endif; ?>
							</a>
						</div>
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</ul>

			<!-- Пагинация -->
			<div class="events-archive__pagination page-pagination">
				<?php
				$total_pages = $events_query->max_num_pages;
				if ($total_pages > 1):
					echo paginate_links([
						'base' => add_query_arg('paged', '%#%'),
						'format' => '',
						'current' => $paged,
						'total' => $total_pages,
						'prev_text' => '<span class="page-pagination__next page-pagination__prev">Предыдущая<span>',
						'next_text' => '<span class="page-pagination__btn page-pagination__next">Следующая<span>',
					]);
				endif; ?>
			</div>
		<?php else: ?>
			<div class="events-archive__no-results">
				<p>События не найдены.</p>
			</div>
		<?php endif; ?>

	</div>
</section>