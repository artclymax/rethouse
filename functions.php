<?php

//require_once get_template_directory() . '/functions/vite.php';

// === Helpers ===
require_once get_template_directory() . '/functions/helpers/theme_asset_version.php';
require_once get_template_directory() . '/functions/helpers/print_dump.php';
require_once get_template_directory() . '/functions/helpers/mx_logo.php';
require_once get_template_directory() . '/functions/helpers/mx_pagination.php';
//require_once get_template_directory() . '/functions/helpers/mx_category_list.php';
require_once get_template_directory() . '/functions/helpers/trim_text.php';
require_once get_template_directory() . '/functions/helpers/correct_phone.php';
require_once get_template_directory() . '/functions/helpers/smart_breadcrumbs.php';


/* get_json_from_query
$json = get_json_from_query($query);
<div class="select-products-data" data-select-from-acf="<?= esc_attr($json) ?>"></div>
*/
//require_once get_template_directory() . '/functions/helpers/get_json_from_query.php';

/** Добавление картинки для кастомных полей в таблице админки
 * add_admin_thumbnail_column('castom-post-slug'); // projects
 */
//require_once get_template_directory() . '/functions/helpers/add_admin_thumbnail_column.php';
//add_admin_thumbnail_column('portfolio');

//require_once get_template_directory() . '/functions/helpers/get_prev_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/get_next_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/custom_product_category.php';
//require_once get_template_directory() . '/functions/helpers/get_product_attributes_array.php';

// === BASE ====
// Общая настройка темы (лого, название и т.п.)
require_once get_template_directory() . '/functions/default_settings.php';

// Подключение стилей
require_once get_template_directory() . '/functions/connect_styles.php';

// Подключение скриптов
require_once get_template_directory() . '/functions/connect_scripts.php';

// Отключение стилей Woocommerce
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Поддержка темы на Woocommerce
add_action('after_setup_theme', function () {
	add_theme_support('woocommerce');
});
// Создание меню
require_once get_template_directory() . '/functions/register_nav_menus.php';

// Регистрация новых записей
require_once get_template_directory() . '/functions/register_post_type.php';

// Кастомная админка (новая версия)
require_once get_template_directory() . '/functions/admin/admin-page.php';
require_once get_template_directory() . '/functions/admin/plugin-installer.php';
//add_action('admin_init', function() {
//    if (current_user_can('manage_options')) {
//        delete_transient('verda_admin_post_types');
//    }
//});
// Создание SCF-полей
require_once get_template_directory() . '/functions/scf_data.php';

function mx_fix_orphans($text)
{
	if (is_admin())
		return $text;
	if (!is_string($text))
		return $text;

	// Фикс для Safari: удаляем скрытые символы Figma (LSEP \u2028 и PARAGRAPH SEPARATOR \u2029)
	$lsep = json_decode('"\u2028"');
	$psep = json_decode('"\u2029"');
	$text = str_replace(array($lsep, $psep), ' ', $text);

	// Если нет коротких слов — сразу выходим (оптимизация)
	if (!preg_match('/\s[а-яА-Яa-zA-Z]{1,2}\s/u', $text)) {
		return $text;
	}

	// Разделяем текст на блоки: защищённые (script, style, code, pre, textarea) и обычный текст
	$protected_pattern = '/(<script\b[^>]*>.*?<\/script>|<style\b[^>]*>.*?<\/style>|<code\b[^>]*>.*?<\/code>|<pre\b[^>]*>.*?<\/pre>|<textarea\b[^>]*>.*?<\/textarea>)/uis';

	// Разбиваем текст на части: [текст, защищённый_блок, текст, защищённый_блок, ...]
	$parts = preg_split($protected_pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

	$result = '';
	foreach ($parts as $part) {
		// Если часть — защищённый блок (начинается с <script, <style и т.д.), не трогаем
		if (preg_match('/^<(script|style|code|pre|textarea)\b/i', $part)) {
			$result .= $part;
		} else {
			// Иначе применяем замену неразрывных пробелов
			$result .= preg_replace('/(\s|&nbsp;)([а-яА-Яa-zA-Z]{1,2})\s/u', '$1$2&nbsp;', $part);
		}
	}

	return $result;
}

// ACF
add_filter('acf/format_value', 'mx_fix_orphans', 20);
add_filter('the_content', 'mx_fix_orphans', 20);
add_filter('the_title', 'mx_fix_orphans', 20);
add_filter('the_excerpt', 'mx_fix_orphans', 20);
add_filter('nav_menu_item_title', 'mx_fix_orphans', 20);

// Внимание: навигация и ACF требуют осторожности
// add_filter('nav_menu_item_title', 'mx_fix_orphans', 20); 
// add_filter('acf/format_value', 'mx_fix_orphans', 20); 


add_action('admin_head', function () {
	echo '<style>
        #postexcerpt p {
            display: none !important;
        }
    </style>';
});
//add_filter('big_image_size_threshold', '__return_false');

add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {

	$front_page_id = get_option('page_on_front');

	// Если это крошка главной
	//if (in_array('home', $type) || $front_page_id) {
	//	return get_the_title($front_page_id);
	//}
	if (in_array('home', $type)) {
		return 'Главная';
	}
	//if (in_array('shop', $type) || $title === 'Товары' || $title === 'Shop') {
	//	return 'Каталог';
	//}
	return $title;

}, 10, 3);

// Убираем разделитель
add_filter('bcn_display_separator', '__return_empty_string');



// === CF7 Redirect: Редирект после отправки формы ===
require_once get_template_directory() . '/functions/cf7-redirect.php';

// === CF7 Leads: Собственная система хранения заявок (замена Flamingo) ===
require_once get_template_directory() . '/functions/cf7-leads.php';

// === CF7: переопределение email получателя через настройки сайта ===
add_filter('wpcf7_mail_components', function ($components, $form) {
	$custom_email = get_option('form_email_to');

	if (!empty($custom_email) && is_email($custom_email)) {
		$components['recipient'] = $custom_email;
	}

	return $components;
}, 10, 2);

add_filter('wpcf7_autop', '__return_false', 20);
add_filter('wpcf7_form_elements', function ($content) {
	//$content = preg_replace('/<span class="wpcf7-form-control-wrap.*?">(.*?)<\/span>/is', '$1', $content);
	$content = str_replace('<br />', '', $content);
	return $content;
});


function sort_all_post_types_by_menu_order($query)
{

	if (is_admin() || !$query->is_main_query()) {
		return;
	}


	$post_type = $query->get('post_type');


	if (empty($post_type) || $post_type === 'any' || is_array($post_type) || is_string($post_type)) {
		$query->set('orderby', 'menu_order');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'sort_all_post_types_by_menu_order', 99);

add_filter('woocommerce_get_breadcrumb', 'custom_product_breadcrumb', 20, 2);
function custom_product_breadcrumb($crumbs, $breadcrumb)
{

	// Проверяем, что мы на странице товара ИЛИ в категории товара
	if ((is_product() || is_product_category()) && !empty($crumbs)) {
		$new_crumbs = array();

		// 1. Оставляем "Главная" (это всегда первый элемент массива)
		$new_crumbs[] = $crumbs[0];

		// 2. Вставляем "Каталог"
		$shop_page_id = wc_get_page_id('shop');
		$shop_url = $shop_page_id > 0 ? get_permalink($shop_page_id) : home_url('/shop/');

		$new_crumbs[] = array('Каталог', $shop_url);

		// 3. Добавляем остальные элементы (Категория, Подкатегория, Товар)
		for ($i = 1; $i < count($crumbs); $i++) {
			$new_crumbs[] = $crumbs[$i];
		}

		// Перезаписываем массив крошек
		$crumbs = $new_crumbs;
	}

	return $crumbs;
}

/**
 * Кастомная сортировка для архива резидентов
 */
add_action('pre_get_posts', 'custom_resident_sorting', 100);
function custom_resident_sorting($query)
{
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('resident')) {

		if (!isset($_GET['orderby'])) {
			// Если параметра нет — не трогаем сортировку.
			// Работает стандартная menu_order/ASC из хука темы.
			return;
		}

		$orderby = sanitize_text_field($_GET['orderby']);

		// Если выбрано "По умолчанию" — тоже не трогаем
		if ($orderby === 'default') {
			return;
		}

		// Сбрасываем пагинацию при смене сортировки
		$query->set('paged', 1);

		switch ($orderby) {
			case 'date_desc':
				$query->set('orderby', 'date');
				$query->set('order', 'DESC');
				break;
			case 'title_asc':
				$query->set('orderby', 'title');
				$query->set('order', 'ASC');
				break;
			case 'title_desc':
				$query->set('orderby', 'title');
				$query->set('order', 'DESC');
				break;
		}
	}
}

/**
 * Ограничиваем поиск только по резидентам и товарам WooCommerce
 */
add_action('pre_get_posts', 'restrict_search_to_residents_and_products');
function restrict_search_to_residents_and_products($query)
{

	// Применяем только к поиску на фронтенде
	if (!is_admin() && $query->is_search && $query->is_main_query()) {

		// Устанавливаем типы записей для поиска
		$query->set('post_type', array('resident', 'product'));

		// Исключаем товары, которые не опубликованы
		$query->set('post_status', 'publish');
	}
}

function get_russian_plural($number, $one, $two, $five)
{
	$number = (int) $number;
	$mod10 = $number % 10;
	$mod100 = $number % 100;

	if ($mod10 === 1 && $mod100 !== 11) {
		$form = $one;
	} elseif ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
		$form = $two;
	} else {
		$form = $five;
	}

	return $number . ' ' . $form;
}


/**
 * Кастомный AJAX обработчик для удаления из избранного (с проверкой всех возможных форматов хранения)
 */
add_action('wp_ajax_woosw_custom_remove', 'custom_woosw_remove_handler');
add_action('wp_ajax_nopriv_woosw_custom_remove', 'custom_woosw_remove_handler');

function custom_woosw_remove_handler()
{
	$product_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$woosw_key = isset($_COOKIE['woosw_key']) ? sanitize_text_field($_COOKIE['woosw_key']) : '';

	$debug_info = [
		'received_id' => $product_id,
		'received_key' => $woosw_key,
		'all_cookies' => $_COOKIE,
	];

	if (!$product_id) {
		wp_send_json_error(['message' => 'Неверный ID товара', 'debug' => $debug_info]);
	}

	// Пробуем разные варианты ключей
	$possible_keys = [];
	if ($woosw_key) {
		$possible_keys[] = 'woosw_list_' . $woosw_key;
	}

	// Также проверяем для авторизованных пользователей
	$user_id = get_current_user_id();
	if ($user_id) {
		$user_key = get_user_meta($user_id, 'woosw_key', true);
		if ($user_key) {
			$possible_keys[] = 'woosw_list_' . $user_key;
		}
	}

	// Если ключей нет, пробуем найти любую опцию с префиксом woosw_list
	if (empty($possible_keys)) {
		global $wpdb;
		$options = $wpdb->get_col("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'woosw_list_%'");
		$possible_keys = $options;
	}

	$debug_info['possible_keys'] = $possible_keys;

	$removed = false;
	$removed_from = '';

	foreach ($possible_keys as $option_name) {
		$wishlist_data = get_option($option_name, []);

		if (is_array($wishlist_data) && !empty($wishlist_data)) {
			$debug_info['checked_option'] = $option_name;
			$debug_info['current_keys'] = array_keys($wishlist_data);

			$found = false;
			$key_to_unset = null;

			if (array_key_exists($product_id, $wishlist_data)) {
				$found = true;
				$key_to_unset = $product_id;
			} elseif (array_key_exists((string) $product_id, $wishlist_data)) {
				$found = true;
				$key_to_unset = (string) $product_id;
			}

			if ($found) {
				unset($wishlist_data[$key_to_unset]);
				$updated = update_option($option_name, $wishlist_data);

				if ($updated) {
					$removed = true;
					$removed_from = $option_name;
					break;
				}
			}
		}
	}

	if ($removed) {
		wp_send_json_success([
			'message' => "Товар удален из $removed_from",
			'debug' => $debug_info
		]);
	} else {
		// Даже если не нашли, считаем успехом (товар уже удален или никогда не был добавлен)
		wp_send_json_success([
			'message' => 'Товар не найден в базе (возможно, уже удален)',
			'debug' => $debug_info
		]);
	}
}

/**
 * Ранний патч для предотвращения ошибки "fragments" в WPC Smart Wishlist
 */
add_action('wp_head', 'early_woosw_fragments_patch', 1);
function early_woosw_fragments_patch()
{
	?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// 1. Гарантируем существование объектов до загрузки плагина
			window.woosw_params = window.woosw_params || {};
			window.woosw_params.fragments = window.woosw_params.fragments || {};
			window.woosw_vars = window.woosw_vars || {};
			window.woosw_vars.fragments = window.woosw_vars.fragments || {};

			// 2. Перехватываем завершение любого AJAX-запроса
			jQuery(document).ajaxComplete(function (event, xhr, settings) {
				// Проверяем, что это запрос на удаление из вишлиста WPC
				if (settings.data && typeof settings.data === 'string' && settings.data.includes('action=woosw_remove')) {

					// Извлекаем ID товара из данных запроса
					const match = settings.data.match(/id=(\d+)/);
					if (match) {
						const productId = match[1];

						// Находим кнопку на странице
						const $btn = jQuery(`.woosw-btn[data-id="${productId}"]`);

						if ($btn.length) {
							// Принудительно меняем классы кнопки, имитируя успешное удаление
							$btn.removeClass('woosw-btn-added woosw-added')
								.addClass('woosw-btn-remove woosw-remove')
								.attr('aria-label', 'Добавить в список желаний');

							// Обновляем иконку (если плагин использует SVG или font-awesome)
							// Обычно достаточно смены классов, но можно добавить:
							// $btn.find('.woosw-btn-icon').removeClass('woosw-icon-8').addClass('woosw-icon-7'); // пример

							console.log('✅ Товар ' + productId + ' вручную удален из интерфейса (обход ошибки fragments)');
						}
					}
				}
			});
		});
	</script>
	<?php
}