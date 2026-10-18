<?php
$page = get_queried_object();

// Инициализация переменных
$label = get_field('contacts_label', $page) ?? '';
$title = get_field('contacts_title', $page) ?? '';
$descr = get_field('contacts_descr', $page) ?? '';
$map = get_field('contacts_map', 'option') ?? '';
$image = get_field('contacts_image', $page) ?? null;

// Защитная обёртка
if ($title || $descr || $map || ($image && !empty($image['ID']))):
	?>
	<section class="section-full section-contacts " id="section-contacts">
		<div class="container section-contacts__container">
			<div class="section-contacts__box card-box">
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
					'descr' => $descr
				]); ?>

				<?php get_template_part('partials/components/contacts-box'); ?>
			</div>
		</div>

		<div class="section-contacts__map image-box jarallax">
			<?php if (!empty($map)): ?>
				<?php echo wp_kses($map, [
					'iframe' => [
						'src' => true,
						'width' => true,
						'height' => true,
						'style' => true,
						'allowfullscreen' => true,
						'loading' => true,
						'frameborder' => true,
					],
				]); ?>
			<?php elseif ($image && is_array($image) && !empty($image['ID'])): ?>
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'full',
					false,
					[
						'class' => 'img jarallax-img',
						'alt' => $image['alt'] ?: $title,
						'loading' => 'lazy'
					]
				); ?>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>