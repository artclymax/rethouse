<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 10;

$reviews_query = new WP_Query([
	'post_type' => 'reviews',
	'post_status' => 'publish',
	'posts_per_page' => $posts_per_page,
	'paged' => $paged,
	'orderby' => 'date',
	'order' => 'DESC',
]);
?>

<section class="section reviews-archive" id="reviews-archive">
	<div class="container reviews-archive__container">
		<!-- Сетка отзывов -->
		<?php if ($reviews_query->have_posts()): ?>
			<div class="reviews-archive__grid">
				<?php
				$index = 1;
				while ($reviews_query->have_posts()):
					$reviews_query->the_post();
					$review_id = get_the_ID();
					$review_title = get_the_title();
					$review_content = get_the_content();
					$review_position = get_field('review_position', $review_id) ?? '';
					$review_video_url = get_field('review_video_url', $review_id)['url'] ?? '';

					// Определяем, есть ли видео
					$has_video = !empty($review_video_url);

					// Ссылка для Fancybox (видео) или на страницу отзыва
					$link_url = $has_video ? $review_video_url : get_the_post_thumbnail_url() ?? '';
					?>
					<div
						class="about-media__media-box reviews-archive__item <?= $index == 1 ? 'reviews-archive__item--first' : '' ?> <?= $index == 10 ? 'reviews-archive__item--last' : '' ?>">
						<a class="about-media__image-link image-box <?php echo $has_video ? 'about-media__image-link--video' : ''; ?>"
							<?php if ($has_video): ?> data-fancybox="reviews" <?php endif; ?> href="
					<?php echo esc_url($link_url); ?>">

							<?php if (has_post_thumbnail($review_id)): ?>
								<?php echo the_post_thumbnail(
									'large',
									[
										'class' => 'img',
										'alt' => $review_title,
										'loading' => 'lazy',
									]
								); ?>
							<?php endif; ?>
						</a>

						<!-- Контент под медиа -->
						<div class="about-media__note">
							<h3 class="about-media__title text-btn">
								<?php the_title() ?>
							</h3>

							<?php if ($review_position): ?>
								<p class="about-media__position label">
									<?php echo esc_html(strtoupper($review_position)); ?>
								</p>
							<?php endif; ?>
							<?php if ($review_content): ?>
								<div class="about-media__descr descr">
									<?php echo wp_kses_post($review_content); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php
					$index++;
				endwhile;
				wp_reset_postdata(); ?>
			</div>

			<!-- ==================== ПАГИНАЦИЯ ==================== -->

			<?php
			$total_pages = $reviews_query->max_num_pages;
			if ($total_pages > 1):
				?>
				<div class="page-pagination">
					<?php
					echo paginate_links([
						'base' => add_query_arg('paged', '%#%'),
						'format' => '',
						'current' => $paged,
						'total' => $total_pages,
						'prev_text' => '<span class="page-pagination__next page-pagination__prev">Предыдущая<span>',
						'next_text' => '<span class="page-pagination__btn page-pagination__next">Следующая<span>',
					]);
					?>
				</div>
			<?php endif; ?>

		<?php else: ?>
			<div class="reviews-archive__no-results">
				<p>Отзывов пока нет.</p>
			</div>
		<?php endif; ?>

	</div>
</section>