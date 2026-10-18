<?php
$page = 'options';

$title = get_field('page_404_title', $page) ?? get_the_title();
$descr = get_field('page_404_descr', $page) ?? '';
$btn = get_field('page_404_btn', $page) ?? '';
$image = get_field('page_404_image', $page) ?? '';


$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));

if ($has_content || $image):
	?>
	<section class="section home-hero hero-page hero-404 <?php echo (!$image ? 'hero-page-no-image' : ''); ?>" id="hero-404">
		<div class="container home-hero__container">
			<div class="home-hero__wrapper">

				<!-- Левая колонка: контент -->
				<?php if ($has_content): ?>
					<div class="home-hero__content">
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
				<?php if ($image): ?>
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