<?php
// 1. Считываем параметры фильтрации
$current_cats = isset($_GET['f_cat']) ? array_map('sanitize_text_field', (array) $_GET['f_cat']) : [];
$current_samples = isset($_GET['f_sample']) ? array_map('sanitize_text_field', (array) $_GET['f_sample']) : [];
$current_mats = isset($_GET['f_mat']) ? array_map('sanitize_text_field', (array) $_GET['f_mat']) : [];

// 2. Собираем tax_query
$tax_query = [];
if (!empty($current_cats))
	$tax_query[] = ['taxonomy' => 'resident_category', 'field' => 'slug', 'terms' => $current_cats];
if (!empty($current_samples))
	$tax_query[] = ['taxonomy' => 'res_attr_sample-order', 'field' => 'slug', 'terms' => $current_samples];
if (!empty($current_mats))
	$tax_query[] = ['taxonomy' => 'res_attr_material', 'field' => 'slug', 'terms' => $current_mats];
if (count($tax_query) > 1)
	$tax_query['relation'] = 'AND';

// 3. Настраиваем запрос
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = [
	'post_type' => 'resident',
	'posts_per_page' => 12, // Укажите ваше количество на страницу
	'paged' => $paged,
	'post_status' => 'publish',
];
if (!empty($tax_query))
	$args['tax_query'] = $tax_query;

$custom_query = new WP_Query($args);
?>

<div class="catalog-grid">
	<?php if ($custom_query->have_posts()): ?>
		<ul class="catalog-grid__list grid">
			<?php while ($custom_query->have_posts()):
				$custom_query->the_post();

				// Безопасное получение ACF картинки (защита от ошибок PHP 8)
				$acf_image = get_field('hero_image');
				$image = [];
				if (is_array($acf_image) && !empty($acf_image['ID'])) {
					$image = $acf_image;
				} elseif (is_numeric($acf_image) && $acf_image > 0) {
					$image['ID'] = $acf_image;
					$image['alt'] = get_post_meta($acf_image, '_wp_attachment_image_alt', true);
				}
				?>
				<li class="catalog-grid__item catalog-card-grid">
					<a class="catalog-card-grid__link-wrapper" href="<?php the_permalink(); ?>">
						<div class="catalog-card-grid__image image-box">
							<?php if (!empty($image) && !empty($image['ID'])): ?>
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'large',
									false,
									[
										'class' => 'img',
										'alt' => !empty($image['alt']) ? esc_attr($image['alt']) : ''
									]
								); ?>
							<?php else: ?>
								<?php the_post_thumbnail('full', ['class' => 'obj-fit-contain']); ?>
							<?php endif; ?>
						</div>
						<h3 class="catalog-card-grid__title text-btn">
							<?php the_title(); ?>
						</h3>
						<div class="catalog-card-grid__descr descr text-small">
							<?php the_excerpt(); ?>
						</div>
						<span class="catalog-card-grid__link link-arrow">
							Подробнее
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<div class="catalog-grid__pagination page-pagination">
			<?php
			// Передаем $custom_query вместо глобального $wp_query, чтобы пагинация работала с фильтром
			// Также исправлены закрывающие теги </span>, которые были сломаны в оригинале
			echo mx_pagination(
				$custom_query,
				'<span class="page-pagination__btn page-pagination__prev">Предыдущая</span>',
				'<span class="page-pagination__btn page-pagination__next">Следующая</span>'
			);
			?>
		</div>

		<?php wp_reset_postdata(); ?>

	<?php else: ?>
		<div class="catalog-grid-not-found">
			<?php
			$filter_count_args = [
				'post_type' => 'resident',
				'posts_per_page' => 1, // Нам нужно только количество, не грузим все посты
				'post_status' => 'publish',
				'fields' => 'ids', // Возвращаем только ID для скорости
			];

			// Добавляем tax_query если есть фильтры
			$current_cats = isset($_GET['f_cat']) ? array_map('sanitize_text_field', (array) $_GET['f_cat']) : [];
			$current_samples = isset($_GET['f_sample']) ? array_map('sanitize_text_field', (array) $_GET['f_sample']) : [];
			$current_mats = isset($_GET['f_mat']) ? array_map('sanitize_text_field', (array) $_GET['f_mat']) : [];

			$tax_query = [];
			if (!empty($current_cats))
				$tax_query[] = ['taxonomy' => 'resident_category', 'field' => 'slug', 'terms' => $current_cats];
			if (!empty($current_samples))
				$tax_query[] = ['taxonomy' => 'res_attr_sample-order', 'field' => 'slug', 'terms' => $current_samples];
			if (!empty($current_mats))
				$tax_query[] = ['taxonomy' => 'res_attr_material', 'field' => 'slug', 'terms' => $current_mats];
			if (count($tax_query) > 1)
				$tax_query['relation'] = 'AND';

			if (!empty($tax_query))
				$filter_count_args['tax_query'] = $tax_query;

			$filter_count_query = new WP_Query($filter_count_args);

			// Передаём этот query в счётчик
			get_template_part('partials/catalog/resident-counter', null, ['query' => $filter_count_query]);
			?>
			<h3 class="catalog-grid-not-found__title title-3">
				По выбранным параметрам ничего не найдено
			</h3>
			<div class="catalog-grid-not-found__descr descr text-small">
				Попробуйте изменить фильтр, поменять категорию или параметры поиска
			</div>
			<!-- Динамическая ссылка сброса (работает на любой странице) -->
			<a class="catalog-grid-not-found__btn btn" href="<?php echo esc_url(get_permalink()); ?>">Сбросить фильтры</a>
		</div>
	<?php endif; ?>
</div>