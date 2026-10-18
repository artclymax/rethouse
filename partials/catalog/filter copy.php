<div class="filter">
	<div class="filter__header">
		<?php get_template_part('partials/catalog/resident-counter'); ?>
		<button class="filter-close-btn" type="button">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10 10L16 16M10 10L4 4M10 10L4 16M10 10L16 4" stroke="#4A4A4C" stroke-width="1.2"
					stroke-linecap="round" />
			</svg>
		</button>
	</div>
	<div class="filter__widget">
		<?php echo do_shortcode('[fe_widget]') ?>
	</div>
</div>