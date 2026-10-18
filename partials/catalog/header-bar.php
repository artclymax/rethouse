<?php
// По умолчанию — "По умолчанию" (menu_order из хука темы)
$current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'default';
?>

<script>
	function handleResidentSort(select) {
		const value = select.value;
		const url = new URL(window.location.href);

		if (value === 'default') {
			// Убираем параметр orderby из URL полностью
			url.searchParams.delete('orderby');
			url.searchParams.delete('paged'); // Сбрасываем пагинацию
		} else {
			url.searchParams.set('orderby', value);
			url.searchParams.delete('paged');
		}

		window.location.href = url.toString();
	}
</script>
<div class="header-bar">
	<!-- Форма поиска по резидентам и товарам -->
	<form role="search" method="get" class="search-form-residents" action="<?php echo esc_url(home_url('/')); ?>">
		<input type="hidden" name="post_type[]" value="resident">
		<input type="hidden" name="post_type[]" value="product">
		<div class="search-form-residents__wrapper">
			<button type="submit" class="search-submit">Найти</button>
			<input type="text" name="s" class="search-input" placeholder="Поиск материала или резидента..."
				value="<?php echo get_search_query(); ?>">
		</div>
	</form>
	<!-- Форма сортировки -->
	<div class="resident-sort-wrapper">
		<!-- action="" означает "отправить на текущий URL", сохраняя все остальные GET-параметры -->
		<form method="get" action="" class="resident-sort-form" id="residentSortForm">
			<select name="orderby" id="resident_orderby" class="sort-select" onchange="handleResidentSort(this)">
				<option value="default" <?php selected($current_orderby, 'default'); ?>>
					По умолчанию
				</option>
				<option value="date_desc" <?php selected($current_orderby, 'date_desc'); ?>>
					По дате добавления
				</option>
				<option value="title_asc" <?php selected($current_orderby, 'title_asc'); ?>>
					По названию (от А до Я)
				</option>
				<option value="title_desc" <?php selected($current_orderby, 'title_desc'); ?>>
					По названию (от Я до А)
				</option>
			</select>
		</form>
	</div>
	<button class="filter-mobile-btn" type="button">
		Фильтры
	</button>
	<?php get_template_part('partials/catalog/resident-counter'); ?>
</div>