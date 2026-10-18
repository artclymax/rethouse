<?php
$page = get_queried_object();
$title = get_field('hero_title', $page) ?? get_the_title() ?? '';
$descr = get_field('hero_descr', $page) ?? get_the_excerpt( ) ?? '';
$btn = get_field('hero_btn', $page) ?? [];
$btn_second = get_field('hero_btn_second', $page) ?? [];
$image = get_field('hero_image', $page) ?? null;

$terms = get_the_terms(get_the_ID(), 'res_attr_material');

// Защитная обёртка
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));
$has_image = ($image && is_array($image) && !empty($image['ID']));
if ($has_content || $has_image):
	?>
	<section class="section home-hero hero-page hero-page-resident" id="hero-page">
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
						
						<?php if (!empty($terms) && !is_wp_error($terms)): ?>
						<ul class="home-hero__materials hero-materials">
							<?php foreach ($terms as $term): ?>
								<li class="hero-materials__item label">
									<?php echo esc_html($term->name); ?>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>

						<?php if (!empty($btn) || !empty($btn__second)): ?>
						<div class="home-hero__btn-box">
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
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<!-- Правая колонка: изображение с jarallax -->
				<div class="home-hero__image home-hero__media">

				<?php if ($has_image): ?>
					<div class="home-hero__image image-box jarallax">
						<?php echo wp_get_attachment_image(
							$image['ID'],
							'large',
							false,
							[
								'class' => 'img jarallax-img',
								'alt' => $image['alt'] ?: $title,
								'loading' => 'lazy'
							]
						); ?>
					
					</div>
				<?php endif; ?>
					<?php if (has_post_thumbnail( )): ?>
						<div class="home-hero__logo image-box">
							<?php the_post_thumbnail() ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>