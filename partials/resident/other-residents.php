<?php
$current_resident_id = get_the_ID();
$label = get_field('other_residents_label', $current_resident_id) ?? 'Материалы и коллекции бренда';
$title = get_field('other_residents_title', $current_resident_id) ?? 'Другие резиденты категории';

$other_residents = new WP_Query([
	'post_type' => 'resident',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'post__not_in' => [$current_resident_id], // Исключаем текущего резидента
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);

// Проверяем, есть ли другие резиденты
if ($other_residents->have_posts()):
	?>
	<section class="section other-residents" id="other-residents">
		<div class="container other-residents__container section-gap">

			<!-- Шапка секции -->
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => ''
			]); ?>

			<!-- Слайдер -->
			<div class="other-residents__gallery">
				<div class="swiper other-residents__swiper other-residents-swiper"
					data-swiper='{ "slidesPerView": 2, "spaceBetween": 8, "rewind": true, "breakpoints": { "768": { "slidesPerView": 3, "spaceBetween": 8 }, "1024": { "slidesPerView": 4, "spaceBetween": 20 }, "1280": { "slidesPerView": 4, "spaceBetween": 24 } } }'>

					<div class="swiper-wrapper other-residents__wrapper">
						<?php while ($other_residents->have_posts()):
							$other_residents->the_post();
							$resident_id = get_the_ID();
							$resident_title = get_the_title();
							$resident_link = get_permalink($resident_id);
							$resident_descr = get_the_excerpt($resident_id) ?? '';
							$resident_hero_image = get_field('hero_image', $resident_id) ?? '';
							// Миниатюра резидента (изображение)
							$resident_thumb_id = get_post_thumbnail_id($resident_id);
							?>
							<div class="swiper-slide other-residents__slide other-residents-slide">
								<div class="other-residents-slide__wrapper customers-card">
									<a class="customers-card__wrapper-link" href="<?php echo esc_url($resident_link); ?>">

										<!-- Изображение -->
										<div class="customers-card__image image-box">
											<?php if ($resident_hero_image): ?>
												<?php echo wp_get_attachment_image(
													$resident_hero_image['ID'],
													'large',
													false,
													array(
														'class' => 'img',
														'alt' => $resident_hero_image['alt'] ?: ''
													)
												); ?>
											<?php else: ?>
												<?php echo wp_get_attachment_image(
													$resident_thumb_id,
													'large',
													false,
													[
														'class' => 'img obj-fit-contain',
														'alt' => $resident_title,
														'loading' => 'lazy'
													]
												); ?>
											<?php endif; ?>
										</div>


										<!-- Заголовок -->
										<h3 class="customers-card__title text-btn">
											<?php echo esc_html($resident_title); ?>
										</h3>

										<!-- Описание -->
										<?php if ($resident_descr): ?>
											<div class="customers-card__descr descr">
												<?php echo wp_kses_post($resident_descr); ?>
											</div>
										<?php endif; ?>

										<!-- Кнопка -->
										<span class="customers-card__btn link-arrow">
											Подробнее
										</span>

									</a>
								</div>
							</div>
						<?php endwhile; ?>
					</div>

					<!-- Пагинация -->
					<div class="swiper-pagination other-residents__pagination" data-swiper-pagination=".other-residents-swiper">
					</div>
				</div>
				<button class="swiper-btn swiper-btn__prev other-residents__btn other-residents__prev hidden-mobile"
					data-swiper-btn-prev=".other-residents-swiper" aria-label="Назад"></button>
				<button class="swiper-btn swiper-btn__next other-residents__btn other-residents__next hidden-mobile"
					data-swiper-btn-next=".other-residents-swiper" aria-label="Вперёд"></button>
			</div>
		</div>
	</section>

	<?php
	// Сбрасываем данные после кастомного запроса
	wp_reset_postdata();
endif;
?>