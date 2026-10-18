<?php

// Получаем поля ACF
$label = get_field('clients_order_label') ?? '';
$title = get_field('clients_order_title') ?? '';
$descr = get_field('clients_order_descr') ?? '';
$features = get_field('clients_order_features') ?? [];
$btn = get_field('clients_order_button') ?? null;
$image = get_field('clients_order_image') ?? null;

// Если нет ни заголовка, ни изображения — не выводим секцию
if (!$title && !$image) {
	return;
}


if ($btn && !empty($btn['url'])) {
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	$btn_target = !empty($btn['target']) ? $btn['target'] : '_self';
}
?>

<section class="section clients-order" id="clients-order">
	<div class="container clients-order__container">
		<div class="clients-order__wrapper bg-block jarallax">

			<!-- Контент -->
			<div class="clients-order__content">

				<!-- Заголовок секции -->
				<?php if ($title || $descr || $label): ?>
					<?php get_template_part('partials/section-header', null, [
						'label' => $label,
						'title' => $title,
						'descr' => $descr,
					]); ?>
				<?php endif; ?>

				<!-- Список преимуществ -->
				<?php if (!empty($features) && is_array($features)): ?>
					<ul class="clients-order__list">
						<?php foreach ($features as $feature):
							$feature_text = $feature['feature_text'] ?? '';
							if (!$feature_text)
								continue;
							?>
							<li class="clients-order__item icon icon--list">
								<?php echo esc_html($feature_text); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<!-- Кнопка -->
				<?php if ($btn_url): ?>
					<a class="clients-order__btn btn" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="<?php echo esc_attr($btn_target); ?>" <?php endif; ?>>
						<?php echo esc_html($btn_title); ?>
					</a>
				<?php endif; ?>

			</div>

			<!-- Фоновое изображение для Jarallax -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="clients-order__image image-box jarallax-img">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img',
							'alt' => $image['alt'] ?: ($title ?: 'Встреча с клиентами'),
							'loading' => 'lazy'
						]
					); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>