<?php
$page = get_queried_object();
$title = get_field('hero_title', $page) ?: get_the_title() ?? '';
$descr = get_field('hero_descr', $page) ?? '';
$btn = get_field('hero_btn', $page) ?? [];
$btn_second = get_field('hero_btn_second', $page) ?? [];
$image = get_field('hero_image', $page) ?? null;

if (is_archive() || is_tax()) {
	$archive_name = get_queried_object()->has_archive;
	if (is_tax()) {
		$archive_name = get_taxonomy(get_queried_object()->taxonomy)->object_type[0];
	}

	$page = get_page_by_path($archive_name, OBJECT, 'page');
	$title = get_field('hero_title', $page) ?: get_the_archive_title() ?: get_the_title() ?: '';
	$descr = get_field('hero_descr', $page) ?? '';
	$btn = get_field('hero_btn', $page) ?? '';
	$btn_second = get_field('hero_btn_second', $page)  ?? '';

	$image = get_field('hero_image', $page) ?? '';
}
// Защитная обёртка
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));
$has_image = ($image && is_array($image) && !empty($image['ID']));

if ($has_content || $has_image):
	?>
	<section class="section home-hero hero-page <?php echo (!$has_image ? 'hero-page-no-image' : ''); ?>" id="hero-page">
		<div class="container home-hero__container">
			<div class="home-hero__wrapper">

				<!-- Левая колонка: контент -->
				<?php if ($has_content): ?>
					<div class="home-hero__content">
						<div class="hero-hero__breadcrumbs page-breadcrumbs">
							<?php if (function_exists('bcn_display')) {
								bcn_display();
							} ?>
						</div>

						<?php get_template_part('partials/section-header', null, [
							'title' => $title,
							'descr' => $descr,
							'h1' => true
						]); ?>

						<?php if (!empty($btn) || !empty($btn__second)): ?>

							<?php if (!empty($btn) && !empty($btn['url'])): ?>
								<a class="home-hero__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
									<?php echo esc_html($btn['title']); ?>
								</a>
							<?php endif; ?>
							<?php if (!empty($btn_second) && !empty($btn_second['url'])): ?>
								<a class="home-hero__btn btn btn--stroke" href="<?php echo esc_url($btn_second['url']); ?>" <?php if (!empty($btn_second['target'])): ?>target="<?php echo esc_attr($btn_second['target']); ?>" <?php endif; ?>>
									<?php echo esc_html($btn_second['title']); ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<!-- Правая колонка: изображение с jarallax -->
				<?php if ($has_image): ?>
					<div class="home-hero__image image-box">
						<?php echo wp_get_attachment_image(
							$image['ID'],
							'large',
							false,
							[
								'class' => 'img ',
								'alt' => $image['alt'] ?: $title,
								'loading' => 'lazy'
							]
						); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>