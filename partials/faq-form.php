<?php
$post_id = get_the_ID();

// Получаем поля ACF
$title = get_field('faq_form_title', $post_id) ?? 'Не нашли нужный ответ?';
$descr = get_field('faq_form_descr', $post_id) ?? 'Напишите нам — подскажем по каталогу, размещению, консультациям или возможностям сотрудничества.';
$form_shortcode = get_field('faq_form_form_shortcode', $post_id) ?? '[contact-form-7 id="52ec5ee" title="Форма страницы вопрос-ответ"]';
$image = get_field('faq_form_image', $post_id) ?? null;

// Если нет ни заголовка, ни формы, ни изображения — не выводим секцию
if (!$title && !$form_shortcode && !$image) {
	return;
}
?>
<section class="section faq-form" id="faq-form">
	<div class="container faq-form__container">
		<div class="faq-form__wrapper">

			<!-- Контент -->
			<div class="faq-form__content">
				<h2 class="faq-form__title title-2">
					<?php echo esc_html($title); ?>
				</h2>
				<div class="faq-form__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
			</div>

			<!-- Форма -->
			<div class="faq-form__form">
				<?php if ($form_shortcode): ?>
					<?php echo do_shortcode($form_shortcode); ?>
				<?php endif; ?>
			</div>

			<!-- Фоновое изображение -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="faq-form__image image-box jarallax">
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