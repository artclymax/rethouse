<?php
/**
 * Template Name: Подборка (Wishlist)
 */
$image = get_field('wishlist_empty_image') ?? null;
$title = get_field('wishlist_empty_title') ?? 'В избранном пока нет материалов';
$descr = get_field('wishlist_empty_descr') ?? 'ДДобавляйте понравившиеся материалы со страниц резидентов, чтобы собрать свою подборку для интерьера и обсудить её на консультации.';
$btn = get_field('wishlist_empty_button') ?? null;
get_header();

// ==================== ВСПОМОГАТЕЛЬНАЯ ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ РЕЗИДЕНТА ====================
function get_resident_info($product_id)
{
	$resident_id = get_post_meta($product_id, 'resident_brand', true);

	if (is_array($resident_id)) {
		$resident_id = $resident_id[0] ?? 0;
	}

	if (is_object($resident_id)) {
		$resident_id = $resident_id->ID ?? 0;
	}

	$resident_id = (int) $resident_id;

	if ($resident_id > 0) {
		return [
			'id' => $resident_id,
			'name' => get_the_title($resident_id) ?: 'Без названия',
		];
	}

	return [
		'id' => 0,
		'name' => 'Без резидента',
	];
}

$user_id = get_current_user_id();
$wishlist_product_ids = [];

// ==================== 1. ПОЛУЧЕНИЕ КЛЮЧА ИЗ COOKIES ====================
$woosw_key = isset($_COOKIE['woosw_key']) ? sanitize_text_field($_COOKIE['woosw_key']) : '';

if ($woosw_key) {
	$wishlist_data = get_option('woosw_list_' . $woosw_key, []);
	if (is_array($wishlist_data) && !empty($wishlist_data)) {
		$wishlist_product_ids = array_keys($wishlist_data);
	}
}

if (empty($wishlist_product_ids) && $user_id) {
	$user_key = get_user_meta($user_id, 'woosw_key', true);
	if ($user_key) {
		$wishlist_data = get_option('woosw_list_' . $user_key, []);
		if (is_array($wishlist_data) && !empty($wishlist_data)) {
			$wishlist_product_ids = array_keys($wishlist_data);
		}
	}
}

$wishlist_product_ids = array_filter(array_map('intval', $wishlist_product_ids));

// ==================== 2. ОБРАБОТКА ОЧИСТКИ ====================
if (isset($_GET['clear_wishlist']) && $_GET['clear_wishlist'] === '1') {
	if ($woosw_key) {
		delete_option('woosw_list_' . $woosw_key);
	}
	if ($user_id) {
		delete_user_meta($user_id, 'woosw_key');
	}
	// Удаляем cookie
	setcookie('woosw_key', '', time() - 3600, '/');
	setcookie('woosw_key', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);

	// Принудительный редирект с параметром для показа empty-шаблона
	wp_redirect(get_permalink() . '?wishlist_cleared=1');
	exit;
}

// Если список пуст ИЛИ только что очищен — показываем empty-шаблон
if (empty($wishlist_product_ids) || isset($_GET['wishlist_cleared'])): ?>
	<?php get_template_part('partials/components/hero-page'); ?>
	<?php get_template_part('partials/wishlist/empty'); ?>
	<?php get_footer();
	return;
endif; ?>

<?php get_template_part('partials/components/hero-page'); ?>

<div class="page-wishlist" id="page-wishlist">
	<div class="container page-wishlist__container">
		<!-- WISHLIST STATS -->
		<div class="page-wishlist__stats wishlist-stats">
			<ul class="wishlist-stats__list">
				<li class="wishlist-stats__item">
					<span class="wishlist-stats__number title-3"
						id="stat-materials"><?php echo $products_query->post_count ?? 0; ?></span>
					<span class="wishlist-stats__label text-small">Материалов</span>
				</li>
				<li class="wishlist-stats__item">
					<span class="wishlist-stats__number title-3" id="stat-residents">0</span>
					<span class="wishlist-stats__label text-small">Резидентов</span>
				</li>
				<li class="wishlist-stats__item">
					<span class="wishlist-stats__number title-3" id="stat-categories">0</span>
					<span class="wishlist-stats__label text-small">Категорий</span>
				</li>
			</ul>
			<div class="wishlist-stats__actions">
				<a href="<?php echo esc_url(get_permalink() . '?clear_wishlist=1'); ?>"
					class="wishlist-stats__clear btn btn--stroke btn--icon-remove"
					onclick="return confirm('Очистить всё избранное?')">
					Очистить избранное
				</a>
			</div>
		</div>

		<!-- WISHLIST FILTERS -->
		<div class="page-wishlist__filters wishlist-filters card-box">
			<div class="wishlist-filters__materials" id="material-filters">
				<button class="wishlist-filters__btn active" data-material="all">Все материалы</button>
				<!-- Кнопки материалов будут добавлены через JS -->
			</div>

			<div class="wishlist-filters__controls">
				<div class="wishlist-filters__sort">
					<select class="wishlist-filters__select form-select" id="sort-select">
						<option value="date-desc">По дате (новые)</option>
						<option value="date-asc">По дате (старые)</option>
						<option value="title-asc">По названию (А-Я)</option>
						<option value="title-desc">По названию (Я-А)</option>
						<option value="resident-asc">По резиденту (А-Я)</option>
						<option value="resident-desc">По резиденту (Я-А)</option>
					</select>
				</div>

				<div class="wishlist-filters__group">
					<span class="wishlist-filters__group-label">Группировать</span>
					<div class="wishlist-filters__group-btns">
						<button class="wishlist-filters__group-btn active" data-group="all">Все</button>
						<button class="wishlist-filters__group-btn" data-group="resident">По резидентам</button>
						<button class="wishlist-filters__group-btn" data-group="category">По категориям</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Контейнер для товаров -->
		<div class="page-wishlist__products wishlist-products" id="products-container"></div>
	</div>
</div>

<?php get_template_part('partials/wishlist/cta-section'); ?>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const ajaxUrl = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>';

		// Данные из PHP
		let productsData = <?php
		$products_array = [];

		$current_woosw_key = isset($_COOKIE['woosw_key']) ? sanitize_text_field($_COOKIE['woosw_key']) : '';
		$wishlist_data = [];
		if ($current_woosw_key) {
			$wishlist_data = get_option('woosw_list_' . $current_woosw_key, []);
		} elseif ($user_id) {
			$user_key = get_user_meta($user_id, 'woosw_key', true);
			if ($user_key) {
				$wishlist_data = get_option('woosw_list_' . $user_key, []);
			}
		}

		$temp_query = new WP_Query([
			'post_type' => 'product',
			'post_status' => 'publish',
			'post__in' => $wishlist_product_ids,
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
		]);

		foreach ($temp_query->posts as $post) {
			$product = wc_get_product($post->ID);
			if (!$product)
				continue;

			$resident_info = get_resident_info($post->ID);

			$materials = get_the_terms($post->ID, 'pa_material');
			$material_slugs = [];
			$material_names = [];
			if ($materials && !is_wp_error($materials)) {
				foreach ($materials as $m) {
					$material_slugs[] = $m->slug;
					$material_names[] = $m->name;
				}
			}

			$categories = get_the_terms($post->ID, 'product_cat');
			$category_names = [];
			if ($categories && !is_wp_error($categories)) {
				foreach ($categories as $c)
					$category_names[] = $c->name;
			}

			$added_time = 0;
			if (isset($wishlist_data[$post->ID]['time'])) {
				$added_time = (int) $wishlist_data[$post->ID]['time'];
			} elseif (isset($wishlist_data[(string) $post->ID]['time'])) {
				$added_time = (int) $wishlist_data[(string) $post->ID]['time'];
			}
			if (!$added_time)
				$added_time = strtotime($post->post_date);

			$products_array[] = [
				'id' => $post->ID,
				'title' => $post->post_title,
				'link' => get_permalink($post->ID),
				'image' => get_the_post_thumbnail_url($post->ID, 'woocommerce_thumbnail') ?: wc_placeholder_img_src('woocommerce_thumbnail'),
				'image_alt' => get_the_title($post->ID),
				'resident_id' => $resident_info['id'],
				'resident_name' => $resident_info['name'],
				'material_slugs' => $material_slugs,
				'material_names' => $material_names,
				'category_names' => $category_names,
				'sku' => $product->get_sku(),
				'date' => $added_time,
			];
		}
		wp_reset_postdata();
		echo json_encode($products_array, JSON_UNESCAPED_UNICODE);
		?>;

		let currentMaterial = 'all';
		let currentSort = 'date-desc';
		let currentGroup = 'all';

		const container = document.getElementById('products-container');
		const materialFiltersContainer = document.getElementById('material-filters');
		const sortSelect = document.getElementById('sort-select');
		const groupButtons = document.querySelectorAll('.wishlist-filters__group-btn');
		const statMaterials = document.getElementById('stat-materials');
		const statResidents = document.getElementById('stat-residents');
		const statCategories = document.getElementById('stat-categories');

		function renderProductCard(product) {
			const materialBadge = product.material_names.length > 0 ? `<span class="product-card__material badge">${product.material_names.join(', ')}</span>` : '';
			const skuHtml = product.sku ? `<span class="product-card__sku text-small">Арт. ${product.sku}</span>` : '';

			// 🌟 СОЗДАЁМ СВОЮ КНОПКУ УДАЛЕНИЯ (без классов плагина!)
			const customRemoveButton = `
				<button class="custom-wishlist-remove-btn" data-id="${product.id}" aria-label="Удалить из избранного">
					 <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
						  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
					 </svg>
				</button>
		  `;

			return `
				<div class="product-card" data-product-id="${product.id}">
					 <div class="product-card__image-box">
						  ${customRemoveButton}
						  <a class="product-card__image image-box" href="${product.image}" target="_blank" data-fancybox="">
								<img src="${product.image}" alt="${product.image_alt}" class="img" loading="lazy">
						  </a>
					 </div>
					 <span class="product-card__brand label">${product.resident_name}</span>
					 ${materialBadge}
					 <h3 class="product-card__title text-btn">
						 ${product.title}
					 </h3>
					 ${skuHtml}
				</div>
		  `;
		}

		function updateProducts() {
			let filtered = [...productsData];

			if (currentMaterial !== 'all') {
				filtered = filtered.filter(p => p.material_slugs.includes(currentMaterial));
			}

			filtered.sort((a, b) => {
				const dateA = Number(a.date) || 0;
				const dateB = Number(b.date) || 0;

				switch (currentSort) {
					case 'date-desc': return dateB - dateA;
					case 'date-asc': return dateA - dateB;
					case 'title-asc': return String(a.title).localeCompare(String(b.title), 'ru');
					case 'title-desc': return String(b.title).localeCompare(String(a.title), 'ru');
					case 'resident-asc': return String(a.resident_name).localeCompare(String(b.resident_name), 'ru');
					case 'resident-desc': return String(b.resident_name).localeCompare(String(a.resident_name), 'ru');
					default: return 0;
				}
			});

			const uniqueResidents = new Set(filtered.map(p => p.resident_id).filter(id => id > 0));
			const uniqueCategories = new Set(filtered.flatMap(p => p.category_names));

			if (statMaterials) statMaterials.textContent = filtered.length;
			if (statResidents) statResidents.textContent = uniqueResidents.size;
			if (statCategories) statCategories.textContent = uniqueCategories.size;

			if (filtered.length === 0) {
				container.innerHTML = `<section class="page-wishlist-empty" id="page-wishlist-empty">
	<div class="container page-wishlist-empty__container">
		<div class="page-wishlist-empty__wrapper card-box"><div class="page-wishlist-empty__image image-box jarallax"><?php echo wp_get_attachment_image(
			$image['ID'],
			'large',
			false,
			[
				'class' => 'img jarallax-img',
				'alt' => $image['alt'] ?: $title,
				'loading' => 'lazy'
			]
		); ?>
</div><div class="page-wishlist-empty__content">
				<h3 class="page-wishlist-empty__title title-3">	<?php echo esc_html($title) ?></h3>
				<div class="page-wishlist-empty__descr descr"><?php echo wp_kses_post($descr) ?></div>	<?php if ($btn && !empty($btn['url'])): ?>
					<a class="page-wishlist-empty__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?></div>

		</div>
	</div>
</section>`;
			} else if (currentGroup === 'all') {
				container.innerHTML = `<div class="wishlist-products__grid products-grid grid">${filtered.map(p => `<div class="products-grid__item">${renderProductCard(p)}</div>`).join('')}</div>`;
			} else if (currentGroup === 'resident') {
				const grouped = {};
				filtered.forEach(p => {
					const key = p.resident_id || 0;
					if (!grouped[key]) grouped[key] = { name: p.resident_name, products: [] };
					grouped[key].products.push(p);
				});
				container.innerHTML = Object.values(grouped).map(group => `<div class="wishlist-products__group"><h3 class="wishlist-products__group-title title-3">${group.name}</h3><div class="wishlist-products__grid products-grid grid">${group.products.map(p => `<div class="products-grid__item">${renderProductCard(p)}</div>`).join('')}</div></div>`).join('');
			} else if (currentGroup === 'category') {
				const grouped = {};
				filtered.forEach(p => {
					const catName = p.category_names[0] || 'Без категории';
					if (!grouped[catName]) grouped[catName] = [];
					grouped[catName].push(p);
				});
				container.innerHTML = Object.entries(grouped).map(([catName, products]) => `<div class="wishlist-products__group"><h3 class="wishlist-products__group-title title-3">${catName}</h3><div class="wishlist-products__grid products-grid grid">${products.map(p => `<div class="products-grid__item">${renderProductCard(p)}</div>`).join('')}</div></div>`).join('');
			}
		}

		function initMaterialButtons() {
			const uniqueMaterials = {};
			productsData.forEach(p => {
				p.material_names.forEach((name, index) => {
					uniqueMaterials[p.material_slugs[index]] = name;
				});
			});

			let buttonsHtml = `<button class="wishlist-filters__btn active" data-material="all">Все материалы</button>`;
			for (const [slug, name] of Object.entries(uniqueMaterials)) {
				buttonsHtml += `<button class="wishlist-filters__btn" data-material="${slug}">${name}</button>`;
			}
			materialFiltersContainer.innerHTML = buttonsHtml;

			document.querySelectorAll('#material-filters .wishlist-filters__btn').forEach(btn => {
				btn.addEventListener('click', function () {
					document.querySelectorAll('#material-filters .wishlist-filters__btn').forEach(b => b.classList.remove('active'));
					this.classList.add('active');
					currentMaterial = this.dataset.material;
					updateProducts();
				});
			});
		}

		// 🌟 ОБРАБОТЧИК УДАЛЕНИЯ ДЛЯ НАШЕЙ КАСТОМНОЙ КНОПКИ
		document.addEventListener('click', function (e) {
			const removeBtn = e.target.closest('.custom-wishlist-remove-btn');

			if (removeBtn && removeBtn.dataset.id) {
				e.preventDefault();
				e.stopPropagation();

				const productId = parseInt(removeBtn.dataset.id);
				console.log('🗑️ Удаление товара ID:', productId);

				const card = removeBtn.closest('.product-card');
				if (card) {
					card.style.opacity = '0';
					card.style.transform = 'scale(0.95)';
					card.style.transition = 'all 0.3s ease';
				}

				jQuery.ajax({
					url: ajaxUrl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'woosw_custom_remove',
						id: productId
					},
					success: function (response) {
						console.log('✅ Ответ сервера:', response.data.message);

						productsData = productsData.filter(p => p.id !== productId);
						updateProducts();

						const newCount = productsData.length;
						const headerCounter = document.querySelector('.woosw-menu-item-inner');
						if (headerCounter) {
							headerCounter.setAttribute('data-count', newCount);
						}
					},
					error: function (xhr, status, error) {
						console.error('❌ Ошибка сети AJAX:', error);
						if (card) {
							card.style.opacity = '1';
							card.style.transform = 'scale(1)';
						}
					}
				});
			}
		});

		window.resetFilters = function () {
			currentMaterial = 'all';
			currentSort = 'date-desc';
			currentGroup = 'all';

			sortSelect.value = 'date-desc';
			document.querySelectorAll('.wishlist-filters__group-btn').forEach(btn => btn.classList.remove('active'));
			document.querySelector('[data-group="all"]').classList.add('active');

			initMaterialButtons();
			updateProducts();
		};

		if (sortSelect) {
			sortSelect.addEventListener('change', function () {
				currentSort = this.value;
				updateProducts();
			});
		}

		groupButtons.forEach(btn => {
			btn.addEventListener('click', function () {
				groupButtons.forEach(b => b.classList.remove('active'));
				this.classList.add('active');
				currentGroup = this.dataset.group;
				updateProducts();
			});
		});

		initMaterialButtons();
		updateProducts();
	});
</script>

<?php get_footer(); ?>