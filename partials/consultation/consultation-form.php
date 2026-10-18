<?php
/**
 * Template Part: Consultation Form Section
 * Description: Секция с формой записи на консультацию и параллакс-фоном
 */

$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF
$title = get_field('consultation_form_title', $page_id) ?? '';
$descr = get_field('consultation_form_descr', $page_id) ?? '';
$form_shortcode = get_field('consultation_form_shortcode', $page_id) ?? '';
$image = get_field('consultation_form_image', $page_id) ?? null;

// Если нет ни заголовка, ни формы, ни изображения — не выводим секцию
if (!$title && !$form_shortcode && !$image) {
	return;
}
?>

<section class="section consultation-form" id="consultation-form">
	<div class="container consultation-form__container">
		<div class="consultation-form__wrapper jarallax">

			<!-- Контент с формой -->
			<div class="consultation-form__content">

				<!-- Заголовок и описание -->
				<?php if ($title || $descr): ?>
					<?php get_template_part('partials/section-header', null, [
						'title' => $title,
						'descr' => $descr,
					]); ?>
				<?php endif; ?>

				<!-- Форма -->
				<?php if ($form_shortcode): ?>
					<div class="consultation-form__form">
						<?php echo do_shortcode($form_shortcode); ?>
					</div>
				<?php endif; ?>

			</div>

			<!-- Фоновое изображение для Jarallax -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="consultation-form__image image-box jarallax-img">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img',
							'alt' => $image['alt'] ?: ($title ?: 'Консультация'),
							'loading' => 'lazy',
						]
					); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>