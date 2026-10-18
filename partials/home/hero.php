<?php
$page = get_queried_object();
$label = get_field('home_hero_label', $page) ?? '';
$title = get_field('home_hero_title', $page) ?? '';
$descr = get_field('home_hero_descr', $page) ?? '';
$btn = get_field('home_hero_btn', $page) ?? [];
$btn_second = get_field('home_hero_btn_second', $page) ?? [];
$image = get_field('home_hero_image', $page) ?? null;
$benefits = get_field('home_hero_benefits', $page) ?? [];

if ($title || $descr || !empty($benefits) || ($image && is_array($image) && !empty($image['ID']))):
	?>
	<section class="section home-hero" id="home-hero" >
		<div class="container home-hero__container">
			<div class="home-hero__wrapper">
				<div class="home-hero__content">
					<?php get_template_part('partials/section-header', null, [
						'label' => $label,
						'title' => $title,
						'descr' => $descr,
						'tag_h1' => true
					]); ?>

					<?php if (!empty($btn) || !empty($btn_second)): ?>
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

				<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
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
			</div>

			<?php if (!empty($benefits)): ?>
				<ul class="home-hero__benefits grid list-box">
					<?php foreach ($benefits as $benefit):
						$benefit_image = $benefit['image'] ?? null;
						$benefit_title = $benefit['title'] ?? '';
						$benefit_descr = $benefit['descr'] ?? '';

						if (!$benefit_title && !$benefit_descr)
							continue;
						?>
						<li class="home-hero__benefit-item home-hero-benefit-item item-decor">
							<?php if ($benefit_image && is_array($benefit_image) && !empty($benefit_image['ID'])): ?>
								<div class="home-hero-benefit-item__icon">
									<?php echo wp_get_attachment_image(
										$benefit_image['ID'],
										'medium',
										false,
										[
											'class' => 'img',
											'alt' => $benefit_image['alt'] ?: $benefit_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<div class="home-hero-benefit-item__content">
								<?php if ($benefit_title): ?>
									<h3 class="home-hero-benefit-item__title text-btn">
										<?php echo esc_html($benefit_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($benefit_descr): ?>
									<div class="home-hero-benefit-item__descr descr text-small">
										<?php echo wp_kses_post($benefit_descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>