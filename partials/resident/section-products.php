<?php
/**
 * Template: Section Resident Products
 * Description: Слайдер товаров, привязанных к текущему резиденту
 */

// 1. Инициализация переменных
$resident_id = get_the_ID();
$resident_name = get_the_title();

// Получаем настройки секции из ACF резидента
$label = get_field('resident_products_label', $resident_id) ?? 'Материалы и коллекции бренда';
$title = get_field('resident_products_title', $resident_id) ?? 'Материалы бренда';



// 2. Запрос товаров (ОПТИМИЗИРОВАННЫЙ)
// Используем '=' вместо 'LIKE', так как поле возвращает чистый ID
$products_query = new WP_Query([
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => -1, // Все товары (или укажите число для ограничения)
	'meta_query' => [
		[
			'key' => 'resident_brand',
			'value' => '"' . $resident_id . '"',
			'compare' => 'LIKE',
		],
	],
]);

// 3. Вывод
if ($products_query->have_posts()):
	?>
	<section class="section section-products" id="section-products">
		<div class="container section-products__container section-gap">

			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
			]); ?>

			<div class="section-products__slider">
				<div class="swiper products-swiper"
					data-swiper='{ "rewind": true, "slidesPerView": 2, "spaceBetween": 8, "breakpoints": { "640": { "slidesPerView": 3, "spaceBetween": 12 }, "768": { "slidesPerView": 4, "spaceBetween": 16 }, "1024": { "slidesPerView": 5, "spaceBetween": 20 }, "1280": { "slidesPerView": 6, "spaceBetween": 24 } } }'>

					<div class="swiper-wrapper products__wrapper-swiper">

						<?php while ($products_query->have_posts()):
							$products_query->the_post();
							$product = wc_get_product(get_the_ID());
							if (!$product)
								continue;

							// Материалы (pa_material)
							$materials = get_the_terms(get_the_ID(), 'pa_material');
							$material_name = '';
							if ($materials && !is_wp_error($materials)) {
								$material_name = implode(', ', wp_list_pluck($materials, 'name'));
							}

							$sku = $product->get_sku();
							?>
							<div class="swiper-slide products-slide">
								<div class="products-slide__wrapper product-card">

									<!-- Изображение -->
									<div class="product-card__image-box">
										<!-- Избранное -->
										<?php echo do_shortcode('[woosw id="' . get_the_ID() . '"]'); ?>
										<a class="product-card__image image-box" href="<?php the_post_thumbnail_url() ?>"
											target="_blank" data-fancybox="">
											<?php if (has_post_thumbnail()): ?>
												<?php the_post_thumbnail('woocommerce_thumbnail', [
													'class' => 'img',
													'loading' => 'lazy',
													'alt' => esc_attr(get_the_title()),
												]); ?>
											<?php else: ?>
												<img src="<?php echo esc_url(wc_placeholder_img_src('woocommerce_thumbnail')); ?>"
													alt="<?php echo esc_attr(get_the_title()); ?>" class="img" loading="lazy">
											<?php endif; ?>
										</a>
									</div>
									<!-- Бренд -->
									<span class="product-card__brand label">
										<?php echo esc_html($resident_name); ?>
									</span>

									<!-- Материал -->
									<?php if ($material_name): ?>
										<span class="product-card__material badge">
											<?php echo esc_html($material_name); ?>
										</span>
									<?php endif; ?>

									<!-- Название -->
									<h3 class="product-card__title text-btn">
										<?php the_title(); ?>
									</h3>

									<!-- Артикул -->
									<?php if ($sku): ?>
										<span class="product-card__sku text-small">
											Арт. <?php echo esc_html($sku); ?>
										</span>
									<?php endif; ?>

								</div>
							</div>
						<?php endwhile; ?>

					</div>

					<div class="swiper-pagination products__pagination-swiper visible-mobile"
						data-swiper-pagination=".products-swiper"></div>
				</div>
				<button class="swiper-btn swiper-btn__prev products__btn-swiper products__btn-swiper-prev hidden-mobile"
					type="button" aria-label="Назад" data-swiper-btn-prev=".products-swiper"></button>
				<button class="swiper-btn swiper-btn__next products__btn-swiper products__btn-swiper-next hidden-mobile"
					type="button" aria-label="Вперёд" data-swiper-btn-next=".products-swiper"></button>

			</div>
		</div>
	</section>

	<?php
	// Сброс данных
	wp_reset_postdata();
endif;
?>