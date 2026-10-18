<div class="filter">
	<div class="filter__header">
		<?php
		// В filter.php делаем быстрый запрос только для подсчёта
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
		<button class="filter-close-btn" type="button">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 10L16 16M10 10L4 4M10 10L4 16M10 10L16 4" stroke="#4A4A4C" stroke-width="1.2"
					stroke-linecap="round" />
			</svg>
		</button>
	</div>
	<div class="filter__widget">

		<?php
		// Получаем текущие выборы из URL, чтобы галочки не слетали
		$current_cats = isset($_GET['f_cat']) ? array_map('sanitize_text_field', (array) $_GET['f_cat']) : [];
		$current_samples = isset($_GET['f_sample']) ? array_map('sanitize_text_field', (array) $_GET['f_sample']) : [];
		$current_mats = isset($_GET['f_mat']) ? array_map('sanitize_text_field', (array) $_GET['f_mat']) : [];

		// Уникальная функция с защитой от повторного объявления
		if (!function_exists('my_render_custom_filter_block')) {
			function my_render_custom_filter_block($taxonomy, $param_name, $title, $selected_values)
			{
				$terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
				if (empty($terms) || is_wp_error($terms))
					return;

				echo '<div class="filter-spoiler spoiler-active" data-spoiler> <button class="filter-spoiler__btn" data-spoiler-title type="button"> <h3 class="filter-spoiler__title">' . esc_html($title) . '</h3><span class="filter-spoiler__icon"></span> </button> <div class="filter-spoiler__content" data-spoiler-content>';
				echo '<ul class="my-filter-list">';
				foreach ($terms as $term) {
					$is_checked = in_array($term->slug, $selected_values) ? 'checked' : '';
					$input_id = 'my-filter-' . $param_name . '-' . $term->term_id;
					echo '<li class="my-filter-item">';
					echo '<input class="my-filter-checkbox" type="checkbox" id="' . esc_attr($input_id) . '" name="' . esc_attr($param_name) . '[]" value="' . esc_attr($term->slug) . '" ' . $is_checked . '>';
					echo '<label for="' . esc_attr($input_id) . '">' . esc_html($term->name) . ' <span class="count">(' . $term->count . ')</span></label>';
					echo '</li>';
				}
				echo '</ul></div></div>';
			}
		}
		?>

		<!-- Сама форма -->
		<form method="GET" action="" class="my-custom-filter-form" id="residentsFilterForm">
			<?php
			my_render_custom_filter_block('res_attr_sample-order', 'f_sample', 'Заказ образцов', $current_samples);
			my_render_custom_filter_block('res_attr_material', 'f_mat', 'Категория материала', $current_mats);
			my_render_custom_filter_block('resident_category', 'f_cat', 'Категории', $current_cats);
			?>

			<div class="my-filter-actions">
				<button class="btn btn--accent my-filter-actions__submit" type="submit" class="btn">Применить</button>
				<a href="<?php echo esc_url(home_url('/resident/')); ?>"
					class="btn btn--stroke my-filter-actions__reset">Сбросить</a>
			</div>
		</form>



	</div>
</div>