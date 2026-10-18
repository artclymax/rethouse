<?php

$page_id = $args['page_id'] ?? get_the_ID();

// Получаем поля ACF
$label = get_field('faq_section_label', $page_id) ?? '';
$title = get_field('faq_section_title', $page_id) ?? '';
$btn = get_field('faq_section_button', $page_id) ?? null;
$image = get_field('faq_section_image', $page_id) ?? null;
$questions = get_field('faq_questions', $page_id) ?? [];

// Если нет ни заголовка, ни вопросов — не выводим секцию
if (!$title && empty($questions)) {
	return;
}

if ($btn && !empty($btn['url'])) {
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	$btn_target = !empty($btn['target']) ? $btn['target'] : '_self';
}
?>

<section class="section section-faq" id="section-faq">
	<div class="container section-faq__container section-gap">

		<!-- Шапка секции -->
		<div class="section-faq__header">

			<!-- Заголовок -->
			<?php if ($title || $label): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
				]); ?>
			<?php endif; ?>

			<!-- Кнопка "Посмотреть все" -->
			<?php if ($btn): ?>
				<a class="section-faq__all-link btn btn--stroke btn--stroke-gray" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="
				<?php echo esc_attr($btn_target); ?>" <?php endif; ?>>
					<?php echo esc_html($btn_title); ?>
				</a>
			<?php endif; ?>

		</div>

		<!-- Основной блок с изображением и списком -->
		<div class="section-faq__wrapper">

			<!-- Изображение слева -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="section-faq__image image-box jarallax hidden-mobile">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img jarallax-img',
							'alt' => $image['alt'] ?: ($title ?: 'FAQ'),
							'loading' => 'lazy',
						]
					); ?>
				</div>
			<?php endif; ?>

			<!-- Список вопросов -->
			<?php if (!empty($questions) && is_array($questions)): ?>
				<ul class="section-faq__list">
					<?php foreach ($questions as $index => $faq):
						$faq_title = $faq['question'] ?? '';
						$faq_answer = $faq['answer'] ?? '';
						$is_active = !empty($faq['is_active']);

						// Классы элемента
						$item_classes = ['faq__item', 'faq-item'];
						if ($is_active) {
							$item_classes[] = 'spoiler-active';
						}
						?>
						<li class="<?php echo esc_attr(implode(' ', $item_classes)); ?>" data-spoiler>

							<!-- Заголовок-кнопка -->
							<button class="faq-item__btn" data-spoiler-title>
								<h3 class="faq-item__title text-btn">
									<?php echo esc_html($faq_title); ?>
								</h3>
								<div class="faq-item__icon"></div>
							</button>

							<!-- Контент (ответ) -->
							<div class="faq-item__content" data-spoiler-content>
								<?php if ($faq_answer): ?>
									<div class="faq-item__descr descr">
										<?php echo wp_kses_post($faq_answer); ?>
									</div>
								<?php endif; ?>
							</div>

						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</div>
</section>