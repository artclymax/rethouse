<?php
$page_id = $args['page_id'] ?? get_the_ID();
// Получаем поля ACF
$image = get_field('resident_cta_image', $page_id) ?? null;
$title = get_field('resident_cta_title', $page_id) ?? '';
$descr = get_field('resident_cta_descr', $page_id) ?? '';
$btn = get_field('resident_cta_btn', $page_id) ?? null;
$no_jarallax = $args['no-jarallax'] ?? false;

if (!$title && !$image) {
	return;
}

// Формируем ссылку кнопки
$btn_url = '#';
$btn_title = 'Оставить заявку';
$btn_target = '_self';

if ($btn && !empty($btn['url'])) {
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	$btn_target = !empty($btn['target']) ? $btn['target'] : '_self';
}
?>

<section class="section resident-cta" id="resident-cta">
	<div class="container resident-cta__container">
		<div class="resident-cta__body <?php echo !$no_jarallax ? 'jarallax' : ''; ?>">

			<!-- Контент -->
			<div class="resident-cta__content">
				<?php if ($title): ?>
					<h2 class="resident-cta__title title-2">
						<?php echo esc_html($title); ?>
					</h2>
				<?php endif; ?>

				<div class="resident-cta__box">
					<?php if ($descr): ?>
						<div class="resident-cta__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>

					<?php if ($btn_url): ?>
						<a class="resident-cta__btn btn" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="
						<?php echo esc_attr($btn_target); ?>" <?php endif; ?>>
							<?php echo esc_html($btn_title); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Фоновое изображение для Jarallax -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="resident-cta__image image-box <?php echo !$no_jarallax ? 'jarallax-img' : ''; ?>">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'full',
						false,
						[
							'class' => 'img',
							'alt' => $image['alt'] ?: $title,
						]
					); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>