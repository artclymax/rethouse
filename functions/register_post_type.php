<?php
function register_event_cat_taxonomy()
{
	register_taxonomy('event_cat', 'events', [
		'label' => 'Категории событий',
		'labels' => [
			'name' => 'Категории событий',
			'singular_name' => 'Категория',
			'add_new_item' => 'Добавить категорию',
			'edit_item' => 'Редактировать категорию',
			'search_items' => 'Найти категорию',
			'all_items' => 'Все категории',
			'parent_item' => 'Родительская категория',
			'parent_item_colon' => 'Родительская категория:',
			'not_found' => 'Категории не найдены',
		],
		'public' => true,
		'hierarchical' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'events/category'],
	]);
}
add_action('init', 'register_event_cat_taxonomy');

// CPT "События"

function register_events_cpt()
{
	register_post_type('events', [
		'label' => 'События',
		'labels' => [
			'name' => 'Календарь мероприятий',
			'singular_name' => 'Событие',
			'add_new' => 'Добавить событие',
			'add_new_item' => 'Добавить новое событие',
			'edit_item' => 'Редактировать событие',
			'new_item' => 'Новое событие',
			'view_item' => 'Просмотр события',
			'search_items' => 'Найти событие',
			'not_found' => 'События не найдены',
			'not_found_in_trash' => 'В корзине событий не найдено',
			'all_items' => 'Все события',
		],
		'public' => true,
		'has_archive' => 'events',
		'show_ui' => true,
		'show_in_rest' => true,
		'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
		'menu_icon' => 'dashicons-calendar-alt',
		'rewrite' => ['slug' => 'events'],
		'menu_position' => 5,
	]);

	// ДОБАВЛЕНО: Регистрация уникальных меток конкретно для событий
	register_taxonomy('event_tag', ['events'], [
		'hierarchical' => false, // false делает таксономию метками (не рубриками)
		'labels' => [
			'name' => 'Метки событий',
			'singular_name' => 'Метка события',
			'search_items' => 'Найти метку',
			'all_items' => 'Все метки',
			'edit_item' => 'Редактировать метку',
			'update_item' => 'Обновить метку',
			'add_new_item' => 'Добавить новую метку',
			'new_item_name' => 'Название новой метки',
			'menu_name' => 'Метки',
		],
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'event-tag'],
	]);
}
add_action('init', 'register_events_cpt');
/**
 * Регистрация CPT "Резиденты" и таксономий
 */

// ============================================
// 1. РЕГИСТРАЦИЯ CPT "РЕЗИДЕНТЫ"
// ============================================
function register_residents_post_type()
{
	$labels = array(
		'name' => _x('Материалы и резиденты', 'Post Type General Name', 'textdomain'),
		'singular_name' => _x('Резидент', 'Post Type Singular Name', 'textdomain'),
		'menu_name' => __('Резиденты', 'textdomain'),
		'name_admin_bar' => __('Резидент', 'textdomain'),
		'archives' => __('Материалы и резиденты', 'textdomain'),
		'attributes' => __('Атрибуты резидента', 'textdomain'),
		'parent_item_colon' => __('Родительский резидент:', 'textdomain'),
		'all_items' => __('Все резиденты', 'textdomain'),
		'add_new_item' => __('Добавить нового резидента', 'textdomain'),
		'add_new' => __('Добавить нового', 'textdomain'),
		'new_item' => __('Новый резидент', 'textdomain'),
		'edit_item' => __('Редактировать резидента', 'textdomain'),
		'update_item' => __('Обновить резидента', 'textdomain'),
		'view_item' => __('Просмотреть резидента', 'textdomain'),
		'view_items' => __('Просмотреть резидентов', 'textdomain'),
		'search_items' => __('Искать резидента', 'textdomain'),
		'not_found' => __('Не найдено', 'textdomain'),
		'not_found_in_trash' => __('Не найдено в корзине', 'textdomain'),
		'featured_image' => __('Логотип резидента', 'textdomain'),
		'set_featured_image' => __('Установить логотип резидента', 'textdomain'),
		'remove_featured_image' => __('Удалить логотип резидента', 'textdomain'),
		'use_featured_image' => __('Использовать как логотип резидента', 'textdomain'),
		'insert_into_item' => __('Вставить в резидента', 'textdomain'),
		'uploaded_to_this_item' => __('Загружено для этого резидента', 'textdomain'),
		'items_list' => __('Список резидентов', 'textdomain'),
		'items_list_navigation' => __('Навигация по списку резидентов', 'textdomain'),
		'filter_items_list' => __('Фильтровать список резидентов', 'textdomain'),
	);

	$args = array(
		'label' => __('Резидент', 'textdomain'),
		'description' => __('Бренды-резиденты каталога', 'textdomain'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
		'taxonomies' => array('resident_category', 'resident_material', 'resident_sample_order'),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-store',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => 'resident', // URL архива: /residents/
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'show_in_rest' => true, // Поддержка Gutenberg и REST API
		'rewrite' => array(
			'slug' => 'residents',
			'with_front' => false
		),
	);

	register_post_type('resident', $args);
}
add_action('init', 'register_residents_post_type', 0);


// ============================================
// 2. РЕГИСТРАЦИЯ ТАКСОНОМИИ "КАТЕГОРИИ РЕЗИДЕНТОВ"
// ============================================
function register_resident_category_taxonomy()
{
	$labels = array(
		'name' => _x('', 'Taxonomy General Name', 'textdomain'),
		'singular_name' => _x('', 'Taxonomy Singular Name', 'textdomain'),
		'menu_name' => __('Категории', 'textdomain'),
		'all_items' => __('Все категории', 'textdomain'),
		'parent_item' => __('Родительская категория', 'textdomain'),
		'parent_item_colon' => __('Родительская категория:', 'textdomain'),
		'new_item_name' => __('Новая категория', 'textdomain'),
		'add_new_item' => __('Добавить новую категорию', 'textdomain'),
		'edit_item' => __('Редактировать категорию', 'textdomain'),
		'update_item' => __('Обновить категорию', 'textdomain'),
		'view_item' => __('Просмотреть категорию', 'textdomain'),
		'separate_items_with_commas' => __('Разделить категории запятыми', 'textdomain'),
		'add_or_remove_items' => __('Добавить или удалить категории', 'textdomain'),
		'choose_from_most_used' => __('Выбрать из часто используемых', 'textdomain'),
		'popular_items' => __('Популярные категории', 'textdomain'),
		'search_items' => __('Искать категории', 'textdomain'),
		'not_found' => __('Не найдено', 'textdomain'),
		'no_terms' => __('Нет категорий', 'textdomain'),
		'items_list' => __('Список категорий', 'textdomain'),
		'items_list_navigation' => __('Навигация по списку категорий', 'textdomain'),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true, // Иерархическая (как категории)
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'show_in_rest' => true,
		'rewrite' => array(
			'slug' => 'resident-category',
			'with_front' => false
		),
	);

	register_taxonomy('resident_category', array('resident'), $args);
}
add_action('init', 'register_resident_category_taxonomy', 0);

/**
 * Система атрибутов для CPT "Резиденты" (независимая от WooCommerce)
 */

// ============================================
// 1. РЕГИСТРАЦИЯ CPT "АТРИБУТЫ РЕЗИДЕНТОВ"
// ============================================
function register_resident_attributes_post_type()
{
	$labels = array(
		'name' => _x('Атрибуты резидентов', 'Post Type General Name', 'textdomain'),
		'singular_name' => _x('Атрибут', 'Post Type Singular Name', 'textdomain'),
		'menu_name' => __('Атрибуты', 'textdomain'),
		'name_admin_bar' => __('Атрибут', 'textdomain'),
		'add_new' => __('Добавить новый', 'textdomain'),
		'add_new_item' => __('Добавить новый атрибут', 'textdomain'),
		'new_item' => __('Новый атрибут', 'textdomain'),
		'edit_item' => __('Редактировать атрибут', 'textdomain'),
		'view_item' => __('Просмотреть атрибут', 'textdomain'),
		'all_items' => __('Все атрибуты', 'textdomain'),
		'search_items' => __('Искать атрибуты', 'textdomain'),
		'not_found' => __('Атрибутов не найдено', 'textdomain'),
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => 'edit.php?post_type=resident', // Подменю в "Резидентах"
		'query_var' => false,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'supports' => array('title'), // Только заголовок (название атрибута)
		'show_in_rest' => true,
	);

	register_post_type('resident_attribute', $args);
}
add_action('init', 'register_resident_attributes_post_type', 0);


// ============================================
// 2. ДОБАВЛЯЕМ ПОЛЯ ДЛЯ АТРИБУТА (SLUG И ТИП)
// ============================================
function add_resident_attribute_meta_boxes()
{
	add_meta_box(
		'resident_attribute_settings',
		'Настройки атрибута',
		'render_resident_attribute_meta_box',
		'resident_attribute',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'add_resident_attribute_meta_boxes');

function render_resident_attribute_meta_box($post)
{
	wp_nonce_field('save_resident_attribute', 'resident_attribute_nonce');

	$slug = get_post_meta($post->ID, '_attribute_slug', true);
	$type = get_post_meta($post->ID, '_attribute_type', true);
	$hierarchical = get_post_meta($post->ID, '_attribute_hierarchical', true);

	?>
	<table class="form-table">
		<tr>
			<th><label for="attribute_slug">Slug (латиницей)</label></th>
			<td>
				<input type="text" id="attribute_slug" name="attribute_slug" value="<?php echo esc_attr($slug); ?>"
					class="regular-text" required>
				<p class="description">Используется для URL и таксономии. Только латиница, цифры и дефис. Например: material,
					color, size</p>
			</td>
		</tr>
		<tr>
			<th><label for="attribute_type">Тип</label></th>
			<td>
				<select id="attribute_type" name="attribute_type">
					<option value="select" <?php selected($type, 'select'); ?>>Выпадающий список (Select)</option>
					<option value="checkbox" <?php selected($type, 'checkbox'); ?>>Чекбоксы (Checkbox)</option>
				</select>
				<p class="description">Как будет отображаться в админке резидента</p>
			</td>
		</tr>
		<tr>
			<th><label for="attribute_hierarchical">Иерархический</label></th>
			<td>
				<label>
					<input type="checkbox" id="attribute_hierarchical" name="attribute_hierarchical" value="1" <?php checked($hierarchical, '1'); ?>>
					Да (как категории, с подкатегориями)
				</label>
				<p class="description">Если отмечено, атрибут будет иерархическим (как категории). Если нет - как метки.</p>
			</td>
		</tr>
	</table>
	<?php
}

function save_resident_attribute_meta($post_id)
{
	if (!isset($_POST['resident_attribute_nonce']) || !wp_verify_nonce($_POST['resident_attribute_nonce'], 'save_resident_attribute')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['attribute_slug'])) {
		$slug = sanitize_title($_POST['attribute_slug']);
		update_post_meta($post_id, '_attribute_slug', $slug);
	}

	if (isset($_POST['attribute_type'])) {
		update_post_meta($post_id, '_attribute_type', sanitize_text_field($_POST['attribute_type']));
	}

	$hierarchical = isset($_POST['attribute_hierarchical']) ? '1' : '0';
	update_post_meta($post_id, '_attribute_hierarchical', $hierarchical);
}
add_action('save_post_resident_attribute', 'save_resident_attribute_meta');


// ============================================
// 3. ДИНАМИЧЕСКАЯ РЕГИСТРАЦИЯ ТАКСОНОМИЙ ДЛЯ АТРИБУТОВ
// ============================================
function register_dynamic_resident_attribute_taxonomies()
{
	$attributes = get_posts(array(
		'post_type' => 'resident_attribute',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	));

	foreach ($attributes as $attribute) {
		$slug = get_post_meta($attribute->ID, '_attribute_slug', true);
		$hierarchical = get_post_meta($attribute->ID, '_attribute_hierarchical', true);

		if (empty($slug)) {
			continue;
		}

		$taxonomy_name = 'res_attr_' . $slug;
		$label = $attribute->post_title;

		$labels = array(
			'name' => $label,
			'singular_name' => $label,
			'menu_name' => $label,
			'all_items' => 'Все ' . $label,
			'edit_item' => 'Редактировать ' . $label,
			'view_item' => 'Просмотреть ' . $label,
			'update_item' => 'Обновить ' . $label,
			'add_new_item' => 'Добавить новый ' . $label,
			'new_item_name' => 'Новое значение ' . $label,
			'parent_item' => 'Родительский ' . $label,
			'parent_item_colon' => 'Родительский ' . $label . ':',
			'search_items' => 'Искать ' . $label,
			'popular_items' => 'Популярные ' . $label,
			'separate_items_with_commas' => 'Разделить ' . $label . ' запятыми',
			'add_or_remove_items' => 'Добавить или удалить ' . $label,
			'choose_from_most_used' => 'Выбрать из часто используемых ' . $label,
			'not_found' => 'Не найдено',
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => ($hierarchical === '1'),
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_in_rest' => true,
			'rewrite' => array(
				'slug' => 'resident-' . $slug,
				'with_front' => false,
			),
		);

		register_taxonomy($taxonomy_name, array('resident'), $args);
	}
}
add_action('init', 'register_dynamic_resident_attribute_taxonomies', 100);


// ============================================
// 4. ПОКАЗЫВАЕМ АТРИБУТЫ В АДМИНКЕ РЕЗИДЕНТА
// ============================================
function add_resident_attributes_meta_boxes()
{
	$attributes = get_posts(array(
		'post_type' => 'resident_attribute',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	));

	foreach ($attributes as $attribute) {
		$slug = get_post_meta($attribute->ID, '_attribute_slug', true);
		$type = get_post_meta($attribute->ID, '_attribute_type', true);

		if (empty($slug)) {
			continue;
		}

		$taxonomy_name = 'res_attr_' . $slug;

		add_meta_box(
			'resident_attr_' . $slug,
			$attribute->post_title,
			'render_resident_attribute_value_meta_box',
			'resident',
			'side',
			'default',
			array(
				'taxonomy' => $taxonomy_name,
				'type' => $type,
			)
		);
	}
}
add_action('add_meta_boxes', 'add_resident_attributes_meta_boxes');

function render_resident_attribute_value_meta_box($post, $metabox)
{
	$taxonomy = $metabox['args']['taxonomy'];
	$type = $metabox['args']['type'];

	$terms = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'ids'));

	$all_terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false,
	));

	if (empty($all_terms) || is_wp_error($all_terms)) {
		echo '<p>Нет доступных значений. <a href="' . admin_url('edit-tags.php?taxonomy=' . $taxonomy . '&post_type=resident_attribute') . '">Добавить значения</a></p>';
		return;
	}

	wp_nonce_field('save_resident_attribute_values', 'resident_attribute_values_nonce');

	if ($type === 'select') {
		echo '<select name="' . $taxonomy . '[]" style="width: 100%;">';
		echo '<option value="">— Выберите —</option>';
		foreach ($all_terms as $term) {
			$selected = in_array($term->term_id, $terms) ? 'selected' : '';
			echo '<option value="' . $term->term_id . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
		}
		echo '</select>';
	} else {
		echo '<ul style="margin: 0; padding: 0; max-height: 200px; overflow-y: auto;">';
		foreach ($all_terms as $term) {
			$checked = in_array($term->term_id, $terms) ? 'checked' : '';
			echo '<li style="margin: 5px 0;">';
			echo '<label>';
			echo '<input type="checkbox" name="' . $taxonomy . '[]" value="' . $term->term_id . '" ' . $checked . '> ';
			echo esc_html($term->name);
			echo '</label>';
			echo '</li>';
		}
		echo '</ul>';
	}
}

function save_resident_attribute_values($post_id)
{
	if (!isset($_POST['resident_attribute_values_nonce']) || !wp_verify_nonce($_POST['resident_attribute_values_nonce'], 'save_resident_attribute_values')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$attributes = get_posts(array(
		'post_type' => 'resident_attribute',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	));

	foreach ($attributes as $attribute) {
		$slug = get_post_meta($attribute->ID, '_attribute_slug', true);

		if (empty($slug)) {
			continue;
		}

		$taxonomy_name = 'res_attr_' . $slug;

		if (isset($_POST[$taxonomy_name])) {
			$term_ids = array_map('intval', $_POST[$taxonomy_name]);
			wp_set_object_terms($post_id, $term_ids, $taxonomy_name);
		} else {
			wp_set_object_terms($post_id, array(), $taxonomy_name);
		}
	}
}
add_action('save_post_resident', 'save_resident_attribute_values');


// ============================================
// 5. ОБНОВЛЕНИЕ ПРАВИЛ ПЕРЕАДРЕСАЦИИ ПРИ СОХРАНЕНИИ АТРИБУТА
// ============================================
function flush_rewrite_rules_on_attribute_save($post_id)
{
	if (get_post_type($post_id) === 'resident_attribute') {
		flush_rewrite_rules();
	}
}
add_action('save_post_resident_attribute', 'flush_rewrite_rules_on_attribute_save');


// ============================================
// 6. ВСПОМОГАТЕЛЬНАЯ ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЯ АТРИБУТОВ РЕЗИДЕНТА
// ============================================
function get_resident_attributes($resident_id)
{
	$attributes = get_posts(array(
		'post_type' => 'resident_attribute',
		'posts_per_page' => -1,
		'post_status' => 'publish',
	));

	$result = array();

	foreach ($attributes as $attribute) {
		$slug = get_post_meta($attribute->ID, '_attribute_slug', true);

		if (empty($slug)) {
			continue;
		}

		$taxonomy_name = 'res_attr_' . $slug;
		$terms = wp_get_post_terms($resident_id, $taxonomy_name);

		if (!empty($terms) && !is_wp_error($terms)) {
			$result[] = array(
				'label' => $attribute->post_title,
				'slug' => $slug,
				'terms' => $terms,
			);
		}
	}

	return $result;
}

/**
 * Регистрация типа записи "Эксперты" (Experts)
 */
add_action('init', 'register_expert_post_type');
function register_expert_post_type()
{
	$labels = [
		'name' => 'Эксперты',
		'singular_name' => 'Эксперт',
		'menu_name' => 'Эксперты',
		'name_admin_bar' => 'Эксперт',
		'add_new' => 'Добавить нового',
		'add_new_item' => 'Добавить нового эксперта',
		'new_item' => 'Новый эксперт',
		'edit_item' => 'Редактировать эксперта',
		'view_item' => 'Посмотреть эксперта',
		'all_items' => 'Все эксперты',
		'search_items' => 'Искать эксперта',
		'not_found' => 'Экспертов не найдено',
		'not_found_in_trash' => 'В корзине экспертов не найдено',
		'featured_image' => 'Фото эксперта',
		'set_featured_image' => 'Установить фото эксперта',
		'remove_featured_image' => 'Удалить фото эксперта',
		'use_featured_image' => 'Использовать как фото эксперта',
	];

	$args = [
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true, // Поддержка Gutenberg
		'query_var' => true,
		'rewrite' => ['slug' => 'expert'],
		'capability_type' => 'post',
		'has_archive' => false, // Архив не нужен, выводим через секцию
		'hierarchical' => false,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-groups', // Иконка "группа людей"
		'supports' => ['title', 'editor', 'custom-fields', 'thumbnail'], // Заголовок (имя) + миниатюра (фото)
	];

	register_post_type('expert', $args);
}

/**
 * Регистрация типа записи "Образование и карьера" (Education & Career)
 */
add_action('init', 'register_education_career_post_type');
function register_education_career_post_type()
{
	$labels = [
		'name' => 'Образование и карьера',
		'singular_name' => 'Образование и карьера',
		'menu_name' => 'Образование и карьера',
		'name_admin_bar' => 'Запись',
		'add_new' => 'Добавить новую',
		'add_new_item' => 'Добавить новую запись',
		'new_item' => 'Новая запись',
		'edit_item' => 'Редактировать запись',
		'view_item' => 'Посмотреть запись',
		'all_items' => 'Все записи',
		'search_items' => 'Искать запись',
		'not_found' => 'Записей не найдено',
		'not_found_in_trash' => 'В корзине записей не найдено',
		'featured_image' => 'Изображение записи',
		'set_featured_image' => 'Установить изображение',
		'remove_featured_image' => 'Удалить изображение',
		'use_featured_image' => 'Использовать как изображение записи',
		'archives' => 'Архив записей',
		'insert_into_item' => 'Вставить в запись',
		'uploaded_to_this_item' => 'Загружено для этой записи',
	];

	$args = [
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true, // Поддержка Gutenberg
		'query_var' => true,
		'rewrite' => [
			'slug' => 'education-career',
			'with_front' => false,
		],
		'capability_type' => 'post',
		'has_archive' => 'education-career', // Без архива
		'hierarchical' => false,
		'menu_position' => 8,
		'menu_icon' => 'dashicons-welcome-learn-more', // Иконка "учёба"
		'supports' => [
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'revisions',
		],
		'taxonomies' => ['education_career_category'], // Привязка к таксономии
	];

	register_post_type('education_career', $args);
}

/**
 * Регистрация таксономии "Категории образования и карьеры"
 */
add_action('init', 'register_education_career_taxonomy');
function register_education_career_taxonomy()
{
	$labels = [
		'name' => 'Категории',
		'singular_name' => 'Категория',
		'search_items' => 'Искать категории',
		'all_items' => 'Все категории',
		'parent_item' => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория:',
		'edit_item' => 'Редактировать категорию',
		'update_item' => 'Обновить категорию',
		'add_new_item' => 'Добавить новую категорию',
		'new_item_name' => 'Название новой категории',
		'menu_name' => 'Категории',
	];

	$args = [
		'hierarchical' => true, // Как обычные категории (не теги)
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true, // Показывать колонку в списке записей
		'show_in_rest' => true, // Поддержка Gutenberg
		'query_var' => true,
		'rewrite' => [
			'slug' => 'education-career-category',
		],
	];

	register_taxonomy('education_career_category', ['education_career'], $args);
}

/**
 * 1. РЕГИСТРАЦИЯ CPT "ЧАСТЫЕ ВОПРОСЫ" (faq)
 */
add_action('init', 'register_faq_post_type');
function register_faq_post_type()
{
	$labels = [
		'name' => 'Частые вопросы',
		'singular_name' => 'Вопрос',
		'menu_name' => 'Частые вопросы',
		'name_admin_bar' => 'Вопрос',
		'add_new' => 'Добавить вопрос',
		'add_new_item' => 'Добавить новый вопрос',
		'new_item' => 'Новый вопрос',
		'edit_item' => 'Редактировать вопрос',
		'view_item' => 'Посмотреть вопрос',
		'all_items' => 'Все вопросы',
		'search_items' => 'Искать вопрос',
		'not_found' => 'Вопросов не найдено',
		'not_found_in_trash' => 'В корзине вопросов не найдено',
	];

	$args = [
		'labels' => $labels,
		'public' => false, // Не публичный тип
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'query_var' => false,
		'rewrite' => false,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 10,
		'menu_icon' => 'dashicons-editor-help',
		'supports' => ['title'],
	];

	register_post_type('faq', $args);
}


/**
 * Регистрация типа записи "Отзывы" (Reviews)
 */
add_action('init', 'register_reviews_post_type');
function register_reviews_post_type()
{
	$labels = [
		'name' => 'Отзывы',
		'singular_name' => 'Отзыв',
		'menu_name' => 'Отзывы',
		'name_admin_bar' => 'Отзыв',
		'add_new' => 'Добавить отзыв',
		'add_new_item' => 'Добавить новый отзыв',
		'new_item' => 'Новый отзыв',
		'edit_item' => 'Редактировать отзыв',
		'view_item' => 'Посмотреть отзыв',
		'all_items' => 'Все отзывы',
		'search_items' => 'Искать отзыв',
		'not_found' => 'Отзывов не найдено',
		'not_found_in_trash' => 'В корзине отзывов не найдено',
		'featured_image' => 'Фото/видео обложка',
		'set_featured_image' => 'Установить обложку',
		'remove_featured_image' => 'Удалить обложку',
		'use_featured_image' => 'Использовать как обложку',
		'archives' => 'Архив отзывов',
	];

	$args = [
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'rewrite' => [
			'slug' => 'reviews',
			'with_front' => false,
		],
		'capability_type' => 'post',
		'has_archive' => 'reviews',
		'hierarchical' => false,
		'menu_position' => 9,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => [
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
		],
	];

	register_post_type('reviews', $args);
}