<?php
// Получаем поля ACF
$label = get_field('resident_brands_label') ?? 'Резиденты RET HOUSE';
$title = get_field('resident_brands_title') ?? 'Бренды, уже представленные в галерее';
$descr = get_field('resident_brands_descr') ?? '';

// Нам нужно получить максимум 12 записей (или все, если их меньше)
$residents_query = new WP_Query([
	'post_type' => 'resident',
	'post_status' => 'publish',
	'posts_per_page' => 12, // Берём не больше 12
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'no_found_rows' => true, // Оптимизация запроса
]);

// Если нет ни заголовка, ни записей — не выводим секцию
if (!$title && !$residents_query->have_posts()) {
	wp_reset_postdata();
	return;
}

// Массив для хранения HTML-кода слайдов
$slides_html = [];

if ($residents_query->have_posts()) {
	while ($residents_query->have_posts()) {
		$residents_query->the_post();

		$resident_id = get_the_ID();
		$resident_title = get_the_title();
		$resident_link = get_permalink($resident_id);

		// Формируем HTML одного слайда
		ob_start();
		?>
		<div class="swiper-slide resident-brands-slide">
			<a class="resident-brands-slide__wrapper-link image-box" href="<?php echo esc_url($resident_link); ?>"
				title="<?php echo esc_attr($resident_title); ?>">
				<?php if (has_post_thumbnail()): ?>
					<?php the_post_thumbnail('full', [
						'class' => 'img obj-fit-contain',
						'loading' => 'lazy',
						'alt' => $resident_title
					]); ?>
				<?php else: ?>
					<span class="resident-brands-slide__fallback title-3">
						<?php echo esc_html($resident_title); ?>
					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php
		$slides_html[] = ob_get_clean();
	}
	wp_reset_postdata();
}

$target_count = 12;
$final_slides = [];
$actual_count = count($slides_html);

if ($actual_count > 0) {
	for ($i = 0; $i < $target_count; $i++) {
		// Оператор % (остаток от деления) зацикливает массив. 
		// Например, если слайдов 4, индексы будут: 0,1,2,3, 0,1,2,3, 0,1,2,3
		$final_slides[] = $slides_html[$i % $actual_count];
	}
}
?>

<section class="section resident-brands" id="resident-brands">
	<div class="container resident-brands__container section-gap">

		<!-- Заголовок секции -->
		<?php if ($title || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr,
			]); ?>
		<?php endif; ?>

		<!-- Карусель Swiper -->
		<?php if (!empty($final_slides)): ?>
			<div class="swiper resident-brands-swiper"
				data-swiper="{'slidesPerView': 'auto', 'spaceBetween': 8, 'loop': true, 'autoplay': { 'delay': 1500 }, 'breakpoints': { '1024': { 'spaceBetween': 24 }}}">

				<div class="swiper-wrapper resident-brands-swiper__wrapper">
					<?php echo implode('', $final_slides); ?>
				</div>

				<div class="swiper-pagination resident-brands-swiper__pagination visible-mobile"
					data-swiper-pagination=".resident-brands-swiper"></div>
			</div>
		<?php endif; ?>

	</div>
</section>