<?php
/**
 * Template Part: Category Section
 * Description: Секция категорий резидентов с динамическим списком и фоновым изображением
 */

$page_id = $args['page_id'] ?? get_the_ID();

// 1. Получаем статические данные из ACF
$label = get_field('category_section_label', $page_id) ?? '';
$title = get_field('category_section_title', $page_id) ?? '';
$image = get_field('category_section_image', $page_id) ?? null;
$btn = get_field('category_section_button', $page_id) ?? null;

// 2. Логика получения категорий
$default_icon = get_template_directory_uri() . '/assets/images/sample-cat-icon.svg';
$exclude_slugs = ['misc'];
$exclude_ids = [];

foreach ($exclude_slugs as $slug) {
	$term = get_term_by('slug', $slug, 'resident_category');
	if ($term) {
		$exclude_ids[] = $term->term_id;
	}
}

$categories = get_terms([
	'taxonomy' => 'resident_category',
	'hide_empty' => false, // Показываем только те, где есть резиденты (было false)
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'parent' => 0,
	'exclude' => $exclude_ids,
]);

if (is_wp_error($categories)) {
	$categories = [];
}

// ==========================================
// УМНАЯ ФУНКЦИЯ ГЕНЕРАЦИИ ССЫЛОК (СИНХРОНИЗАЦИЯ С ФИЛЬТРОМ)
// ==========================================
if (!function_exists('get_category_filter_url')) {
	function get_category_filter_url($term_slug)
	{
		// Базовый URL страницы каталога резидентов
		$base_url = home_url('/resident/');

		// Берем текущие параметры из адресной строки
		$current_params = $_GET;

		// При смене категории всегда сбрасываем пагинацию на 1 страницу
		unset($current_params['paged']);

		if (empty($term_slug)) {
			// Если это кнопка "Все", удаляем фильтр по категории
			unset($current_params['f_cat']);
		} else {
			// Устанавливаем новую категорию (массивом, как в нашем фильтре)
			$current_params['f_cat'] = [$term_slug];
		}

		// Склеиваем URL обратно, сохраняя другие фильтры (f_mat, f_sample)
		if (!empty($current_params)) {
			return add_query_arg($current_params, $base_url);
		}

		return $base_url;
	}
}

// ==========================================
// ОПРЕДЕЛЕНИЕ АКТИВНОЙ КАТЕГОРИИ
// ==========================================
$active_term_slug = '';

// Ищем наш параметр f_cat из нового фильтра
if (isset($_GET['f_cat']) && is_array($_GET['f_cat']) && !empty($_GET['f_cat'])) {
	$active_term_slug = sanitize_text_field($_GET['f_cat'][0]);
}

// Если параметра нет — активна кнопка "Все"
$is_all_active = empty($active_term_slug);

// Если нет ни заголовка, ни категорий, ни картинки — не выводим секцию
if (!$title && empty($categories) && !$image) {
	return;
}
?>

<section class="section-full category-section jarallax" id="category-section">
	<div class="container category-section__container">
		<div class="category-section__wrapper card-box section-gap">

			<!-- Заголовок секции -->
			<?php if ($title || $label): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
				]); ?>
			<?php endif; ?>

			<!-- Список категорий -->
			<ul class="category-section__list shop-category__list">
				<!-- Первый элемент: "Все" -->
				<li class="shop-category__item <?php echo $is_all_active ? 'active-cat' : ''; ?>">
					<a class="shop-category__link" href="<?php echo esc_url(get_category_filter_url('')); ?>">
						<div class="shop-category__icon">
							<img class="img" src="<?php echo esc_url($default_icon); ?>" alt="Все материалы" loading="lazy" />
						</div>
						<span class="shop-category__title text-small">Все материалы</span>
					</a>
				</li>

				<!-- Остальные категории из таксономии -->
				<?php if (!empty($categories)): ?>
					<?php foreach ($categories as $category):
						$term_slug = $category->slug;
						$term_id = (int) $category->term_id;
						$term_name = $category->name ?? '';

						if (!$term_name) {
							continue;
						}

						// Проверяем совпадение slug с активной категорией
						$is_active = ($term_slug === $active_term_slug);

						// Получаем иконку из ACF таксономии
						$cat_icon = get_field('cat_icon', 'term_' . $term_id);
						$icon_url = $default_icon;
						$icon_alt = $term_name;

						if ($cat_icon && is_array($cat_icon) && !empty($cat_icon['ID'])) {
							$icon_url = $cat_icon['url'] ?? $default_icon;
							$icon_alt = !empty($cat_icon['alt']) ? $cat_icon['alt'] : $term_name;
						}
						?>
						<li class="shop-category__item <?php echo $is_active ? 'active-cat' : ''; ?>">
							<a class="shop-category__link" href="<?php echo esc_url(get_category_filter_url($term_slug)); ?>">
								<div class="shop-category__icon">
									<img class="img" src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>"
										loading="lazy" />
								</div>
								<span class="shop-category__title text-small">
									<?php
									echo function_exists('mx_fix_orphans') ? esc_html(mx_fix_orphans($term_name)) : esc_html($term_name);
									?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>

			<!-- Кнопка -->
			<?php if ($btn && !empty($btn['url'])): ?>
				<a class="category-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
					<?php echo esc_html($btn['title']); ?>
				</a>
			<?php endif; ?>

		</div>

		<!-- Фоновое изображение для Jarallax -->
		<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
			<div class="category-section__image image-box jarallax-img">
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'large',
					false,
					[
						'class' => 'img',
						'alt' => !empty($image['alt']) ? esc_attr($image['alt']) : ($title ?: 'Категории'),
						'loading' => 'lazy'
					]
				); ?>
			</div>
		<?php endif; ?>

	</div>
</section>