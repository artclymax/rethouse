<?php
// Путь к иконке по умолчанию
$default_icon = get_template_directory_uri() . '/assets/images/sample-cat-icon.svg';

// Исключаем категорию по slug или ID
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
	'hide_empty' => false, // Показываем только те, где есть резиденты
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'parent' => 0,
	'exclude' => $exclude_ids,
]);

if (is_wp_error($categories)) {
	$categories = [];
}

// ==========================================
// УМНАЯ ФУНКЦИЯ ГЕНЕРАЦИИ ССЫЛОК
// ==========================================
if (!function_exists('get_category_filter_url')) {
	function get_category_filter_url($term_slug)
	{
		// Базовый URL страницы, где выведен ваш catalog.php и filter.php
		// Если страница называется иначе, замените '/resident/' на нужный slug
		$base_url = home_url('/resident/');

		// Берем текущие параметры из адресной строки
		$current_params = $_GET;

		// ВАЖНО: При смене категории всегда сбрасываем пагинацию на 1 страницу
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
	// Если выбрано несколько категорий чекбоксами, подсвечиваем первую
	$active_term_slug = sanitize_text_field($_GET['f_cat'][0]);
}

// Если параметра нет — активна кнопка "Все"
$is_all_active = empty($active_term_slug);

if (!empty($categories) || true):
	?>
	<section class="shop-category" id="shop-category">
		<div class="container shop-category__container">
			<div class="shop-category__body">
				<ul class="shop-category__list">

					<!-- Первый элемент: "Все" -->
					<li class="shop-category__item <?php echo $is_all_active ? 'active-cat' : ''; ?>">
						<a class="shop-category__link" href="<?php echo esc_url(get_category_filter_url('')); ?>">
							<div class="shop-category__icon">
								<img class="img" src="<?php echo esc_url($default_icon); ?>" alt="Все материалы" loading="lazy" />
							</div>
							<span class="shop-category__title text-small">Все материалы</span>
						</a>
					</li>

					<!-- Остальные категории -->
					<?php foreach ($categories as $category):
						$term_slug = $category->slug;
						$term_id = (int) $category->term_id;
						$term_name = $category->name ?? '';

						// Проверяем совпадение slug с активной категорией
						$is_active = ($term_slug === $active_term_slug);

						if (!$term_name) {
							continue;
						}

						// Получаем иконку из ACF
						$cat_icon = get_field('cat_icon', 'term_' . $term_id);
						$icon_url = $default_icon;
						$icon_alt = $term_name;

						if ($cat_icon && is_array($cat_icon) && !empty($cat_icon['ID'])) {
							$icon_url = $cat_icon['url'] ?? $default_icon;
							$icon_alt = $cat_icon['alt'] ?: $term_name;
						}
						?>
						<li class="shop-category__item <?php echo $is_active ? 'active-cat' : ''; ?>">
							<a class="shop-category__link" href="<?php echo esc_url(get_category_filter_url($term_slug)); ?>">
								<div class="shop-category__icon">
									<img class="img" src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>"
										loading="lazy" />
								</div>
								<span class="shop-category__title text-small">
									<?php echo esc_html(function_exists('mx_fix_orphans') ? mx_fix_orphans($term_name) : $term_name); ?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>

				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>