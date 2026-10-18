<?php
// Инициализация переменных
$page = get_queried_object();
$label = get_field('about_media_label', $page) ?? '';
$title = get_field('about_media_title', $page) ?? '';
$descr = get_field('about_media_descr', $page) ?? '';
$image = get_field('about_media_image', $page) ?? null;
$video_file = get_field('about_media_video_file', $page) ?? '';
$media_note = get_field('about_media_note', $page) ?? '';

// URL полноразмерного изображения (для ссылки, если нет видео)
$image_full_url = '';
if ($image && is_array($image) && !empty($image['ID'])) {
	$image_full_url = wp_get_attachment_image_url($image['ID'], 'full');
}
if ($video_file) {
	// Определяем финальный href: видеофайл приоритетнее, иначе — полное изображение
	$link_url = $video_file['url'] ?: $image_full_url ?? null;
}

// Защитная обёртка
$has_content = ($title || $descr || ($image && !empty($image['ID'])) || $media_note);

if ($has_content && $link_url):
	?>
	<section class="section about-media" id="about-media">
		<div class="container about-media__container">

			<?php if ($title || $descr): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
				]); ?>
			<?php endif; ?>

			<div class="about-media__media-box">

				<a class="about-media__image-link image-box jarallax <?php echo $video_file ? 'about-media__image-link--video' : ''; ?>"
					data-fancybox href="<?php echo esc_url($link_url); ?>">

					<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
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
					<?php endif; ?>

				</a>

				<?php if ($media_note): ?>
					<div class="about-media__note descr">
						<?php echo wp_kses_post($media_note); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>