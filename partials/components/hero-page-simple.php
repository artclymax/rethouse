<?php
$title = get_field('hero_page_title') ?: (is_singular() ? get_the_title() : (is_archive() ? get_the_archive_title() : ''));
?>

<section class="hero-page hero-page-simple" id="hero-page">
	<div class="container hero-page__container">
		<div class="hero-page__breadcrumbs">
			<?php woocommerce_breadcrumb(['delimiter' => '']); ?>
		</div>

		<div class="hero-page__content">
			<?php if ($title): ?>
				<h1 class="hero-page__title title-2">
					<?php echo wp_kses_post($title); ?>
				</h1>
			<?php endif; ?>
		</div>
	</div>

</section>