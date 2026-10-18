<?php
$post_id = get_the_ID();

// Получаем поля ACF
$title = get_field('event_cta_title', $post_id) ?? 'Запись на мероприятие';
$descr = get_field('event_cta_descr', $post_id) ?? 'Оставьте заявку, чтобы принять участие во встрече. Мы свяжемся с вами и подтвердим регистрацию.';
$address = get_field('event_cta_address', $post_id) ?? 'Количество мест ограничено.';
$form_shortcode = get_field('event_cta_form_shortcode', $post_id) ?? '[contact-form-7 id="e0c34ff" title="Форма запись на мероприятие"]';
$image = get_field('event_cta_image', $post_id) ?? null;

// Если нет ни заголовка, ни формы, ни изображения — не выводим секцию
if (!$title && !$form_shortcode && !$image) {
	return;
}
?>

<section class="section events-cta" id="events-cta">
	<div class="container events-cta__container">
		<div class="events-cta__wrapper">

			<!-- Контент -->
			<div class="events-cta__content">
				<h2 class="events-cta__title title-2">
					<?php echo esc_html($title); ?>
				</h2>
				<div class="events-cta__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
				<address class="events-cta__address icon icon--location">
					<div class="events-cta__address-descr descr">
						<?php echo wp_kses_post($address); ?>
					</div>
				</address>
			</div>

			<!-- Форма -->
			<div class="events-cta__form" data-event-input-title="<?php echo esc_attr(get_the_title($post_id)); ?>">
				<?php if ($form_shortcode): ?>
					<?php echo do_shortcode($form_shortcode); ?>
				<?php endif; ?>
			</div>

			<!-- Фоновое изображение -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="events-cta__image image-box jarallax">
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

		</div>
	</div>
</section>