<section class="section catalog-page" id="catalog-page">
	<h2 class="visually-hidden">
		<?php the_title(); ?>
	</h2>
	<div class="container catalog-page__container">
		<?php get_template_part('partials/catalog/header-bar'); ?>
		<?php get_template_part('partials/catalog/filter'); ?>
		<?php get_template_part('partials/catalog/catalog-grid'); ?>
	</div>
</section>

