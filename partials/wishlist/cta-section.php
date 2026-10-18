<?php
/**
 * Template Part: CTA Section (Call to Action)
 * Description: Призыв к действию в конце страницы
 */
$image = get_field('cta_image') ?: null;
$title = get_field('cta_title') ?: 'Хотите обсудить сохранённые материалы?';
$descr = get_field('cta_descr') ?: 'Запишитесь на консультацию — специалист RET HOUSE поможет сравнить материалы, уточнить наличие образцов и подобрать сочетания под ваш проект.';
$btn = get_field('cta_button') ?: [];

?>

<section class="section wishlist-cta-section" id="wishlist-cta-section">
	<div class="container wishlist-cta-section__container">
		<div class="wishlist-cta-section__wrapper">
			<div class="wishlist-cta-section__content">
				<h2 class="wishlist-cta-section__title title-2">
					<?php echo wp_kses_post($title); ?>
				</h2>
				<div class="wishlist-cta-section__box">
					<div class="wishlist-cta-section__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
					<?php if (!empty($btn['url'])): ?>
						<a class="wishlist-cta-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
							<?php echo esc_html($btn['title']); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="wishlist-cta-section__image image-box ">
				<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
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
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>