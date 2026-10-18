<?php

// Инициализация переменных
$resident_id = get_the_ID();
$title = get_field('resident_form_title', $resident_id) ?? 'Оставить запрос представителю резидента';
$descr = get_field('resident_form_descr', $resident_id) ?? 'Мы передадим ваш запрос непосредственному представителю резидента. Он свяжется с вами и поможет подобрать продукцию, рассчитать стоимость или назначить встречу в шоуруме.';
$form = get_field('resident_form_shortcode', $resident_id) ?? '[contact-form-7 id="b08afce" title="Оставить запрос представителю резидента"]';
$image = get_field('resident_form_image', $resident_id) ?? null;

// Защитная обёртка
$has_content = ($title || $descr || $form);
$has_image = ($image && is_array($image) && !empty($image['ID']));

if ($has_content || $has_image):
	?>
	<section class="section resident-form" id="resident-form">
		<div class="container resident-form__container">

			<div class="resident-form__wrapper jarallax">

				<?php if ($has_content): ?>
					<div class="resident-form__content">

						<?php get_template_part('partials/section-header', null, [
							'title' => $title,
							'descr' => $descr
						]); ?>

						<?php if ($form): ?>
							<div class="resident-form__form">
								<?php echo do_shortcode($form); ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>

				<?php if ($has_image): ?>
					<div class="resident-form__image image-box jarallax-img">
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
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>