<?php

// Получаем поля ACF
$image = get_field('wishlist_empty_image') ?? null;
$title = get_field('wishlist_empty_title') ?? 'В избранном пока нет материалов';
$descr = get_field('wishlist_empty_descr') ?? 'ДДобавляйте понравившиеся материалы со страниц резидентов, чтобы собрать свою подборку для интерьера и обсудить её на консультации.';
$btn = get_field('wishlist_empty_button') ?? null;

// Если кнопка не задана, используем ссылку на каталог
if (!$btn) {
	$btn = [
		'url' => home_url('/resident/'),
		'title' => 'Перейти  к материалам и резидентам',
	];
}
?>

<section class="page-wishlist-empty" id="page-wishlist-empty">
	<div class="container page-wishlist-empty__container">
		<div class="page-wishlist-empty__wrapper card-box">

			<!-- Изображение с параллаксом -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="page-wishlist-empty__image image-box jarallax">
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
				</div>
			<?php endif; ?>

			<!-- Контент -->
			<div class="page-wishlist-empty__content">
				<h3 class="page-wishlist-empty__title title-3">
					<?php echo esc_html($title) ?>
				</h3>
				<div class="page-wishlist-empty__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
				<!-- Кнопка -->
				<?php if ($btn && !empty($btn['url'])): ?>
					<a class="page-wishlist-empty__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
