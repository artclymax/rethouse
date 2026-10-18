<?php
$current_category = isset($_GET['event_cat']) ? sanitize_text_field($_GET['event_cat']) : '';
$search_query = isset($_GET['event_search']) ? sanitize_text_field($_GET['event_search']) : '';
$current_sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'default';

// ==================== КАТЕГОРИИ ====================
$event_categories = get_terms([
	'taxonomy' => 'event_cat',
	'hide_empty' => false,
]);

?>
<section class="events-header-bar" id="events-header-bar">
	<div class="container events-header-bar__container">
		<div class="events-header-bar__wrapper">
			<ul class="events-header-bar__tabs courses-tabs">
				<li class="courses-tabs__item">
					<a href="<?php echo esc_url(remove_query_arg(['event_cat', 'paged', 'event_search', 'sort'])); ?>"
						class="courses-tabs__btn <?php echo !$current_category ? 'active' : ''; ?>">
						Все события
					</a>
				</li>
				<?php foreach ($event_categories as $cat): ?>
					<li class="courses-tabs__item">
						<a href="<?php echo esc_url(add_query_arg([
							'event_cat' => $cat->slug,
							'paged' => '',
							'sort' => $current_sort !== 'default' ? $current_sort : null,
							'event_search' => $search_query ?: null,
						])); ?>" class="courses-tabs__btn <?php echo $current_category === $cat->slug ? 'active' : ''; ?>">
							<?php echo esc_html($cat->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<!-- Поиск и сортировка -->
			<div class="events-header-bar__controls controls-bar">
				<!-- Поиск -->
				<form class="events-header-bar__search search-bar" method="GET" action="">
					<button type="submit" class="search-bar__btn icon icon--search">
						Поиск
					</button>
					<?php if ($current_category): ?>
						<input type="hidden" name="event_cat" value="<?php echo esc_attr($current_category); ?>">
					<?php endif; ?>
					<?php if ($current_sort && $current_sort !== 'default'): ?>
						<input type="hidden" name="sort" value="<?php echo esc_attr($current_sort); ?>">
					<?php endif; ?>

					<input type="text" name="event_search" class="search-bar__input" placeholder="Поиск по названию..."
						value="<?php echo esc_attr($search_query); ?>">
				</form>

				<!-- Сортировка -->
				<form class="events-header-bar__sort" method="GET" action="">
					<?php if ($current_category): ?>
						<input type="hidden" name="event_cat" value="<?php echo esc_attr($current_category); ?>">
					<?php endif; ?>
					<?php if ($search_query): ?>
						<input type="hidden" name="event_search" value="<?php echo esc_attr($search_query); ?>">
					<?php endif; ?>

					<select name="sort" class="form-select" onchange="this.form.submit()">
						<option value="default" <?php echo $current_sort === 'default' ? 'selected' : ''; ?>>
							По умолчанию
						</option>
						<option value="date_desc" <?php echo $current_sort === 'date_desc' ? 'selected' : ''; ?>>
							По дате (новые)
						</option>
						<option value="date_asc" <?php echo $current_sort === 'date_asc' ? 'selected' : ''; ?>>
							По дате (старые)
						</option>
						<option value="title_asc" <?php echo $current_sort === 'title_asc' ? 'selected' : ''; ?>>
							По названию (А - Я)
						</option>
						<option value="title_desc" <?php echo $current_sort === 'title_desc' ? 'selected' : ''; ?>>
							По названию (Я - А)
						</option>
					</select>
				</form>
			</div>
		</div>
	</div>
</section>