<?php
// Инициализация переменных
$page = get_queried_object();
$label = get_field('cta_label', $page) ?? '';
$title = get_field('cta_title', $page) ?? '';
$descr = get_field('cta_descr', $page) ?? '';
$btn = get_field('cta_btn', $page) ?? [];
$steps = get_field('cta_steps', $page) ?? [];
$bg_image = get_field('cta_bg_image', $page) ?? null;

$class = $args['class'] ?? '';

// Защитная обёртка
$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])) || !empty($steps));
$has_bg = ($bg_image && is_array($bg_image) && !empty($bg_image['ID']));

if ($has_content || $has_bg):
	?>
	<section class="section-full cta-section jarallax <?php echo esc_attr($class); ?>" id="cta-section">
		<div class="container cta-section__container">

			<!-- Фоновое изображение -->
			<?php if ($has_bg): ?>
				<div class="cta-section__bg image-box jarallax-img">
					<?php echo wp_get_attachment_image(
						$bg_image['ID'],
						'full',
						false,
						[
							'class' => 'img',
							'alt' => $bg_image['alt'] ?: $title,
							'aria-hidden' => 'true',
						]
					); ?>
				</div>
			<?php endif; ?>

			<!-- Карточка с контентом -->
			<div class="cta-section__card list-box">

				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
				]); ?>

				<?php if (!empty($steps)): ?>
					<ol class="cta-section__steps steps-list">
						<?php foreach ($steps as $index => $step):
							$step_title = $step['title'] ?? '';
							$step_descr = $step['descr'] ?? '';

							if (!$step_title && !$step_descr)
								continue;
							?>
							<li class="steps-list__item">
								<div class="steps-list__num"></div>
								<?php if ($step_descr): ?>
									<div class="steps-list__descr descr text-small">
										<?php echo wp_kses_post($step_descr); ?>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>

				<?php if (!empty($btn) && !empty($btn['url'])): ?>

					<a class="cta-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
				<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?>

			</div>

		</div>
	</section>
<?php endif; ?>