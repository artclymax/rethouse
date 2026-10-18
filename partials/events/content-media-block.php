<?php
$post_id = get_the_ID();

// Получаем поля ACF
$label = get_field('content_media_label', $post_id) ?? '';
$title = get_field('content_media_title', $post_id) ?? '';
$descr = get_field('content_media_descr', $post_id) ?? '';
$image = get_field('content_media_image', $post_id) ?? null;

// Если нет ни заголовка, ни изображения — не выводим секцию, чтобы не создавать пустые блоки
if (!$title && !$image) {
	return;
}
?>

<section class="section content-media-block" id="content-media-block">
	<div class="container content-media-block__container">

		<!-- Заголовок секции (использует ваш существующий partial) -->
		<?php if ($title || $descr || $label): ?>
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr
			]); ?>
		<?php endif; ?>

		<!-- Изображение -->
		<?php if (!empty($image) && is_array($image) && !empty($image['ID'])): ?>
			<div class="content-media-block__image image-box jarallax">
				<?php echo wp_get_attachment_image(
					(int) $image['ID'],
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
</section>