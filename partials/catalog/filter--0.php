<?php
// 1. Получаем текущие выбранные значения из адресной строки (URL)
$current_cats = isset($_GET['f_cat']) ? array_map('sanitize_text_field', (array) $_GET['f_cat']) : [];
$current_samples = isset($_GET['f_sample']) ? array_map('sanitize_text_field', (array) $_GET['f_sample']) : [];
$current_mats = isset($_GET['f_mat']) ? array_map('sanitize_text_field', (array) $_GET['f_mat']) : [];

// 2. Функция для вывода блока чекбоксов
function my_render_filter_block($taxonomy, $param_name, $title, $selected_values)
{
	// Получаем термины. hide_empty => true скрывает пустые категории (ускоряет работу!)
	$terms = get_terms([
		'taxonomy' => $taxonomy,
		'hide_empty' => true,
	]);

	if (empty($terms) || is_wp_error($terms))
		return;

	echo '<div class="my-filter-section">';
	echo '<h3 class="my-filter-title">' . esc_html($title) . '</h3>';
	echo '<ul class="my-filter-list">';

	foreach ($terms as $term) {
		// Проверяем, выбрана ли эта галочка сейчас
		$is_checked = in_array($term->slug, $selected_values) ? 'checked' : '';
		$input_id = 'my-filter-' . $param_name . '-' . $term->term_id;

		echo '<li class="my-filter-item">';
		// name="f_cat[]" - скобки [] важны, чтобы передавать массив значений
		echo '<input class="my-filter-checkbox" type="checkbox" id="' . esc_attr($input_id) . '" name="' . esc_attr($param_name) . '[]" value="' . esc_attr($term->slug) . '" ' . $is_checked . '>';
		echo '<label for="' . esc_attr($input_id) . '">' . esc_html($term->name) . ' <span class="count">(' . $term->count . ')</span></label>';
		echo '</li>';
	}

	echo '</ul>';
	echo '</div>';
}
?>

<!-- Сама HTML форма -->
<form method="GET" action="" class="my-custom-filter-form" id="residentsFilterForm">
	<?php
	// Выводим наши три блока
	my_render_filter_block('resident_category', 'f_cat', 'Категории', $current_cats);
	my_render_filter_block('res_attr_sample-order', 'f_sample', 'Заказ образцов', $current_samples);
	my_render_filter_block('res_attr_material', 'f_mat', 'Категория материала', $current_mats);
	?>

	<div class="my-filter-actions">
		<button type="submit" class="my-filter-submit">Применить</button>
		<!-- Кнопка сброса просто ведет на чистую страницу без GET параметров -->
		<a href="<?php echo esc_url(get_permalink()); ?>" class="my-filter-reset">Сбросить</a>
	</div>
</form>