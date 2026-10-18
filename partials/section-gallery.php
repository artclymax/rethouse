<?php
// Инициализация переменных
$page = $args['page_id'] ?? get_the_ID();
$label = get_field('gallery_label', $page) ?? '';
$title = get_field('gallery_title', $page) ?? '';
$images = get_field('gallery_images', $page) ?? [];
$max_slides = get_field('gallery_max_slides', $page) ?? 4;

// Защитная обёртка
$has_content = ($title || !empty($images));

if ($has_content):
	?>
	<section class="section section-gallery" id="section-gallery">
		<div class="container section-gallery__container section-gap">

			<?php if ($title): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => ''
				]); ?>
			<?php endif; ?>

			<?php if (!empty($images)): ?>
				<div class="section-gallery__slider">
					<div class="swiper gallery-swiper"
						data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true, "breakpoints": { "640": { "slidesPerView": 2, "spaceBetween": 20 }, "1024": { "slidesPerView": 3, "spaceBetween": 24 } , "1200": { "slidesPerView": <?= esc_attr($max_slides) ?>, "spaceBetween": 24 } } }'>

						<div class="swiper-wrapper gallery-swiper__wrapper">
							<?php foreach ($images as $image):
								$image_id = $image['ID'] ?? 0;
								$image_url = $image['url'] ?? '';
								$image_alt = $image['alt'] ?? $title;

								if (!$image_id || !$image_url)
									continue;

								$image_full_url = wp_get_attachment_image_url($image_id, 'full');
								?>
								<div class="swiper-slide gallery-swiper__slide gallery-item">
									<a class="gallery-item__image-link image-box" href="<?php echo esc_url($image_full_url); ?>"
										data-fancybox="fancybox-photo-gallery">
										<?php echo wp_get_attachment_image(
											$image_id,
											'large',
											false,
											[
												'class' => 'img',
												'alt' => $image_alt,
												'loading' => 'lazy'
											]
										); ?>
									</a>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="swiper-pagination gallery-swiper__pagination visible-mobile"
							data-swiper-pagination=".gallery-swiper"></div>
					</div>
					<button class="swiper-btn swiper-btn__prev gallery-swiper__btn gallery-swiper__prev hidden-mobile"
						data-swiper-btn-prev=".gallery-swiper" aria-label="Назад"></button>
					<button class="swiper-btn swiper-btn__next gallery-swiper__btn gallery-swiper__next hidden-mobile"
						data-swiper-btn-next=".gallery-swiper" aria-label="Вперёд"></button>
				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>