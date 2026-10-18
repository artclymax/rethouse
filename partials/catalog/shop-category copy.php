<?php

// Путь к иконке по умолчанию
$default_icon = get_template_directory_uri() . '/assets/images/sample-cat-icon.svg';

// Исключаем категорию по slug или ID
$exclude_slugs = ['misc'];
$exclude_ids = [];

// Переводим слаги в ID
foreach ($exclude_slugs as $slug) {
	$term = get_term_by('slug', $slug, 'resident_category');
	if ($term) {
		$exclude_ids[] = $term->term_id;
	}
}

$categories = get_terms([
	'taxonomy' => 'resident_category',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'parent' => 0,
	'exclude' => $exclude_ids,
]);

if (is_wp_error($categories)) {
	$categories = [];
}

// ==========================================
// ОПРЕДЕЛЕНИЕ АКТИВНОЙ КАТЕГОРИИ (ОБНОВЛЕНО)
// ==========================================
$active_term_id = 0;

// 1. Сначала проверяем GET-параметры из адресной строки (для AJAX/обычных фильтров)
// Проверяем оба возможных варианта имени параметра. 
// Посмотрите в адресную строку после фильтрации: если там ?category=..., сработает первое.
// Если там ?resident_category=..., сработает второе.
$get_slug = '';
if (isset($_GET['resident_category']) && !empty($_GET['resident_category'])) {
	$get_slug = sanitize_text_field($_GET['resident_category']);
} elseif (isset($_GET['category']) && !empty($_GET['category'])) {
	$get_slug = sanitize_text_field($_GET['category']);
}

if ($get_slug) {
	$term = get_term_by('slug', $get_slug, 'resident_category');
	if ($term && !is_wp_error($term)) {
		$active_term_id = (int) $term->term_id;
	}
}

// 2. Если GET-параметра нет, проверяем стандартный архив таксономии (ЧПУ: /resident_category/name/)
if (empty($active_term_id) && is_tax('resident_category')) {
	$queried = get_queried_object();
	if ($queried && isset($queried->term_id)) {
		$active_term_id = (int) $queried->term_id;
	}
}

// Если активной категории нет ни там, ни там — делаем "Все" активным
$is_all_active = ($active_term_id === 0);

// Проверяем, есть ли что показать
if (!empty($categories) || true): // "Все" показываем всегда
	?>
	<section class="shop-category" id="shop-category">
		<div class="container shop-category__container">
			<div class="shop-category__body">
				<ul class="shop-category__list">
					<!-- Первый элемент: "Все" -->
					<li class="shop-category__item <?php echo $is_all_active ? 'active-cat' : ''; ?>">
						<a class="shop-category__link" href="<?php echo esc_url(home_url('/resident/')); ?>">
							<div class="shop-category__icon">
								<img class="img" src="<?php echo esc_url($default_icon); ?>" alt="Все материалы" loading="lazy" />
							</div>
							<span class="shop-category__title text-small">Все материалы</span>
						</a>
					</li>

					<!-- Остальные категории -->
					<?php foreach ($categories as $category):
						$term_id = (int) $category->term_id;
						$term_link = get_term_link($category);
						$term_name = $category->name ?? '';
						
						// Проверяем совпадение ID с активной категорией
						$is_active = ($term_id === $active_term_id);

						if (!$term_name || is_wp_error($term_link)) {
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
							<a class="shop-category__link" href="<?php echo esc_url($term_link); ?>">
								<div class="shop-category__icon">
									<img class="img" src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" loading="lazy" />
								</div>
								<span class="shop-category__title text-small">
									<?php echo esc_html(mx_fix_orphans($term_name)); ?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>

				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>