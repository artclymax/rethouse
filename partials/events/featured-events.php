<?php
$current_category = isset($_GET['event_cat']) ? sanitize_text_field($_GET['event_cat']) : '';

$featured_args = [
	'post_type' => 'events',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_query' => [
		['key' => 'event_is_featured', 'value' => '1'],
	],
	'orderby' => 'date',
	'order' => 'DESC',
];

if ($current_category) {
	$featured_args['tax_query'] = [
		['taxonomy' => 'event_cat', 'field' => 'slug', 'terms' => $current_category],
	];
}

$featured_query = new WP_Query($featured_args);

$featured_ids = [];
if ($featured_query->have_posts()) {
	while ($featured_query->have_posts()) {
		$featured_query->the_post();
		$featured_ids[] = get_the_ID();
	}
	wp_reset_postdata();
}
function format_event_date($date_string)
{
	if (!$date_string) {
		return null;
	}

	$parts = explode(' ', trim($date_string));

	if (count($parts) < 2) {
		return null;
	}

	$day = $parts[0];
	$month = $parts[1];


	return [
		'number' => $day,
		'month' => $month,
	];
}
if ($featured_query->have_posts()): ?>
	<section class="featured-news" id="featured-news">
		<div class="container featured-news__container">
			<ul class="featured-news__list">
				<?php while ($featured_query->have_posts()):
					$featured_query->the_post();
					$featured_id = get_the_ID();
					$featured_title = get_the_title();
					$featured_link = get_permalink($featured_id);
					$featured_thumb = get_the_post_thumbnail_url($featured_id, 'large');
					$featured_descr = get_field('event_descr', $featured_id) ?: get_the_excerpt();
					$featured_label = get_field('event_featured_label', $featured_id) ?: 'Специальное событие';

					// Получаем дату и форматируем
					$event_date_raw = get_field('event_start_date', $featured_id);
					$formatted_date = format_event_date($event_date_raw);
					$start_time = get_field('event_start_time', $featured_id);

					// Получаем категорию для badge
					$featured_cats = get_the_terms($featured_id, 'event_cat');
					$featured_badge = '';
					if ($featured_cats && !is_wp_error($featured_cats)) {
						$featured_badge = $featured_cats[0]->name;
					}

					?>
					<li class="featured-news__item featured-news-item">
						<a class="featured-news-item__image image-box" href="<?php echo esc_url($featured_link); ?>">
							<?php if ($featured_thumb): ?>
								<img src="<?php echo esc_url($featured_thumb); ?>" alt="<?php echo esc_attr($featured_title); ?>" />
							<?php endif; ?>

							<?php if ($formatted_date): ?>
								<div class="featured-news-item__date">
									<span>
										<?php echo esc_html($formatted_date['number']); ?>
									</span>
									<span>
										<?php echo esc_html($formatted_date['month']); ?>
									</span>
									<span>
										<?php echo esc_html($start_time); ?>
									</span>
								</div>
							<?php endif; ?>
						</a>

						<div class="featured-news-item__content">
							<!-- SectionHeader -->
							<div class="section-header">
								<?php if ($featured_label): ?>
									<span class="section-header__label label">
										<?php echo esc_html($featured_label); ?>
									</span>
								<?php endif; ?>
								<h2 class="section-header__title title-2">
									<a href="<?php echo esc_url($featured_link); ?>">
										<?php echo esc_html($featured_title); ?>
									</a>
								</h2>
							</div>

							<!-- Badge -->
							<?php if ($featured_badge): ?>
								<p class="featured-news-item__badge badge">
									<?php echo esc_html(strtoupper($featured_badge)); ?>
								</p>
							<?php endif; ?>

							<!-- Description -->
							<?php if ($featured_descr): ?>
								<div class="featured-news-item__descr descr">
									<p>
										<?php echo wp_kses_post($featured_descr); ?>
									</p>
								</div>
							<?php endif; ?>

							<!-- Button -->
							<a class="featured-news-item__btn btn" href="<?php echo esc_url($featured_link); ?>">
								Записаться
							</a>
						</div>
					</li>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</ul>
		</div>
	</section>
<?php endif; ?>