<?php
/**
 * Шаблон результатов поиска
 */

get_header();
?>

<main class="site-main search-results-page">
	<div class="container">

		<header class="search-header">
			<h1 class="page-title">
				Результаты поиска: <span class="search-query">
					<?php echo get_search_query(); ?>
				</span>
			</h1>
		</header>

		<?php if (have_posts()): ?>

			<div class="search-results-layout">

				<?php while (have_posts()):
					the_post(); ?>

					<?php
					$post_type = get_post_type();

					// Разделяем результаты по типу
					if ($post_type === 'resident'):
						?>

						<!-- Карточка резидента -->
						<article class="search-result-card resident-result">
							<a href="<?php the_permalink(); ?>" class="result-link">

								<?php if (has_post_thumbnail()): ?>
									<div class="result-image">
										<?php the_post_thumbnail('medium', array('class' => 'resident-logo')); ?>
									</div>
								<?php endif; ?>

								<div class="result-content">
									<span class="result-type">Резидент</span>
									<h2 class="result-title">
										<?php the_title(); ?>
									</h2>
									<div class="result-excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
									</div>
								</div>

							</a>
						</article>

					<?php elseif ($post_type === 'product'): ?>

						<!-- Карточка товара (материала) -->
						<article class="search-result-card product-result">
							<a href="<?php the_permalink(); ?>" class="result-link">

								<?php if (has_post_thumbnail()): ?>
									<div class="result-image">
										<?php the_post_thumbnail('woocommerce_thumbnail', array('class' => 'product-image')); ?>
									</div>
								<?php endif; ?>

								<div class="result-content">
									<span class="result-type">Материал</span>
									<h2 class="result-title">
										<?php the_title(); ?>
									</h2>

									<?php
									// Показываем цену, если есть
									$product = wc_get_product(get_the_ID());
									if ($product && $product->get_price()):
										?>
										<div class="result-price">
											<?php echo $product->get_price_html(); ?>
										</div>
									<?php endif; ?>

									<div class="result-excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
									</div>
								</div>

							</a>
						</article>

					<?php endif; ?>

				<?php endwhile; ?>

			</div>

			<!-- Пагинация -->
			<div class="search-pagination">
				<?php
				the_posts_pagination(array(
					'mid_size' => 2,
					'prev_text' => __('Назад', 'textdomain'),
					'next_text' => __('Вперед', 'textdomain'),
				));
				?>
			</div>

		<?php else: ?>

			<!-- Если ничего не найдено -->
			<div class="no-results">
				<h2>Ничего не найдено</h2>
				<p>По запросу "<strong>
						<?php echo get_search_query(); ?>
					</strong>" ничего не найдено. Попробуйте изменить поисковый запрос.</p>

				<a href="<?php echo esc_url(home_url('/')); ?>" class="button">Вернуться на главную</a>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
?>