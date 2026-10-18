<?php
/**
 * Template: Section Catalog
 * Description: Вывод категорий WooCommerce (карточка = ссылка)
 */

// Инициализация переменных
$page = get_queried_object();
$label = get_field('section_catalog_label', $page) ?? '';
$title = get_field('section_catalog_title', $page) ?? '';
$descr = get_field('section_catalog_descr', $page) ?? '';
$btn = get_field('section_catalog_btn', $page) ?? [];
$note = get_field('section_catalog_note', $page) ?? '';
$categories_repeater = get_field('section_catalog_categories', $page) ?? [];

// Формируем массив категорий из repeater
$categories = [];
if (!empty($categories_repeater)) {
	foreach ($categories_repeater as $item) {
		$category = $item['category'] ?? null;
		if ($category && is_object($category) && isset($category->term_id)) {
			$categories[] = $category;
		}
	}
}

if (empty($categories)) {
	$default_args = [
		'taxonomy' => 'resident_category',
		'hide_empty' => false,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'number' => 8,
		'parent' => 0,
	];
	$categories = get_terms($default_args);
	if (is_wp_error($categories)) {
		$categories = [];
	}
}

// Защитная обёртка: показываем секцию, если есть хотя бы один элемент
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])) || $note);
$has_categories = !empty($categories);

if ($has_content || $has_categories):
	?>
	<section class="section section-catalog" id="catalog">
		<div class="container section-catalog__container section-grid">

			<?php if ($has_content): ?>
				<div class="section-catalog__content">
					<?php get_template_part('partials/section-header', null, [
						'label' => $label,
						'title' => $title,
						'descr' => $descr
					]); ?>

					<?php if (!empty($btn) && !empty($btn['url'])): ?>
						<a class="section-catalog__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title']); ?>
						</a>
					<?php endif; ?>

					<?php if ($note): ?>
						<small class="section-catalog__note text-small icon icon--filter">
							<?php echo esc_html($note); ?>
						</small>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ($has_categories): ?>
				<ul class="section-catalog__grid grid">
					<?php foreach ($categories as $category):
						$cat_link = get_term_link($category);
						$cat_thumb = get_field('cat_card_image', 'term_' . $category->term_id) ?? null;
						$cat_name = $category->name ?? '';

						if (!$cat_name || is_wp_error($cat_link))
							continue;
						?>
						<li class="section-catalog__card catalog-card">
							<a class="catalog-card__link-wrapper card-box" href="<?php echo esc_url($cat_link); ?>"
								aria-label="<?php echo esc_attr('Перейти в категорию: ' . $cat_name); ?>">

								<?php if ($cat_thumb): ?>
									<div class="catalog-card__image image-box">
										<?php echo wp_get_attachment_image(
											(int) $cat_thumb['ID'],
											'large',
											false,
											[
												'class' => 'img',
												'alt' => $cat_name,
												'loading' => 'lazy',
											]
										); ?>
									</div>
								<?php endif; ?>

								<h3 class="catalog-card__title text-btn link-arrow">
									<?php echo esc_html(mx_fix_orphans($cat_name)); ?>
								</h3>

							</a>
						</li>

					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>