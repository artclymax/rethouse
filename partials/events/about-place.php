<?php
$post_id = get_the_ID();

// Получаем поля ACF
$label = get_field('location_label', $post_id) ?? 'Место проведения';
$title = get_field('location_title', $post_id) ?? '';
$address = get_field('location_address', $post_id) ?? '';
$descr = get_field('location_descr', $post_id) ?? '';
$image = get_field('location_image', $post_id) ?? null;

// Если нет ни названия, ни изображения — не выводим секцию
if (!$title && !$image) {
	return;
}
?>

<section class="section about-place" id="about-place">
	<div class="container about-place__container">

		<!-- Фоновое изображение с параллакс-эффектом -->
		<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
			<div class="about-place__image image-box jarallax">
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'large',
					false,
					[
						'class' => 'img jarallax-img',
						'alt' => $image['alt'] ?: $title,
						'loading' => 'lazy',
					]
				); ?>
			</div>
		<?php endif; ?>

		<!-- Контент -->
		<div class="about-place__content">

			<!-- Метка -->
			<?php if ($label): ?>
				<span class="about-place__label label">
					<?php echo esc_html($label); ?>
				</span>
			<?php endif; ?>

			<!-- Название места -->
			<?php if ($title): ?>
				<h2 class="about-place__title title-2">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>

			<!-- Адрес -->
			<?php if ($address): ?>
				<div class="about-place__address icon icon--location">
					<address class="about-place__address-descr descr">
						<?php echo esc_html($address); ?>
					</address>
				</div>
			<?php endif; ?>

			<!-- Описание -->
			<?php if ($descr): ?>
				<div class="about-place__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>