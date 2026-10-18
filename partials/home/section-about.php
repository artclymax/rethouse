<?php
$page = get_queried_object();
$label = get_field('about_label', $page) ?? '';
$title = get_field('about_title', $page) ?? '';
$descr = get_field('about_descr', $page) ?? '';
$quote = get_field('about_quote', $page) ?? '';
$btn = get_field('about_btn', $page) ?? [];
$image = get_field('about_image', $page) ?? null;
$photo = get_field('about_founder_photo', $page) ?? null;
$name = get_field('about_founder_name', $page) ?? '';
$founder_descr = get_field('about_founder_descr', $page) ?? '';

// Защитная обёртка
$has_content = ($title || $descr || $quote || (!empty($btn) && !empty($btn['url'])));
$has_image = ($image && is_array($image) && !empty($image['ID']));
$has_founder = ($name || $founder_descr || ($photo && is_array($photo) && !empty($photo['ID'])));

if ($has_content || $has_image):
	?>
	<section class="section section-about" id="section-about">
		<div class="container section-about__container">

			<div class="section-about__content">
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
				]); ?>

				<?php if ($quote): ?>
					<blockquote class="section-about__blockquote icon icon--logo"
						style="--icon-bg: url('<?= esc_url(get_template_directory_uri() . '/assets/images/logo.svg') ?>');">
						<div class="section-about__descr descr text-small">
							<?php echo wp_kses_post($quote); ?>
						</div>
					</blockquote>
				<?php endif; ?>

				<?php if (!empty($btn) && !empty($btn['url'])): ?>
					<a class="section-about__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ($has_image): ?>
				<div class="section-about__image-wrapper jarallax">
					<div class="section-about__image image-box jarallax-img">
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

					<?php if ($has_founder): ?>
						<div class="section-about__founder about-founder">
							<?php if ($photo && is_array($photo) && !empty($photo['ID'])): ?>
								<div class="about-founder__image image-box">
									<?php echo wp_get_attachment_image(
										$photo['ID'],
										'medium',
										false,
										[
											'class' => 'img',
											'alt' => $photo['alt'] ?: $name,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<div class="about-founder__content card-box">
								<?php if ($name): ?>
									<h3 class="about-founder__name text-btn">
										<?php echo esc_html($name); ?>
									</h3>
								<?php endif; ?>

								<?php if ($founder_descr): ?>
									<div class="about-founder__descr descr text-small">
										<?php echo wp_kses_post($founder_descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>