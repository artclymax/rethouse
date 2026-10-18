<?php
$page = $args['page_id'] ?? get_page_by_path('resident', OBJECT, 'page');
$title = get_field('catalog_cta_title', $page) ?? '';
$descr = get_field('catalog_cta_descr', $page) ?? '';
$btn = get_field('catalog_cta_btn', $page) ?? [];
$image = get_field('catalog_cta_image', $page) ?? null;

$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));
$has_image = ($image && is_array($image) && !empty($image['ID']));

if ($has_content || $has_image):
	?>
	<section class="section catalog-cta" id="catalog-cta">
		<div class="container catalog-cta__container">
			<div class="catalog-cta__wrapper jarallax">
				<?php if ($has_content): ?>
					<div class="catalog-cta__content">
						<?php if ($title): ?>
							<h2 class="catalog-cta__title title-2">
								<?php echo esc_html($title); ?>
							</h2>
						<?php endif; ?>

						<?php if ($descr): ?>
							<div class="catalog-cta__descr descr">
								<?php echo wp_kses_post($descr); ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($btn) && !empty($btn['url'])): ?>
							<a class="catalog-cta__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
					<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
								<?php echo esc_html($btn['title']); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ($has_image): ?>
					<div class="catalog-cta__image__wrapper">
						<div class="catalog-cta__image image-box jarallax-img">
							<?php echo wp_get_attachment_image(
								$image['ID'],
								'large',
								false,
								[
									'class' => 'img',
									'alt' => $image['alt'] ?: $title,
									'loading' => 'lazy'
								]
							); ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>