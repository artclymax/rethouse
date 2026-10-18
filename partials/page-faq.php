<?php

$faq_posts = get_posts([
	'post_type' => 'faq',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);

if (empty($faq_posts)) {
	return;
}

// Активная вкладка (первая по умолчанию)
$active_post_id = $faq_posts[0]->ID;
?>

<section class="page-faq" id="page-faq">
	<div class="container page-faq__container page-gap">

		<div class="page-faq__wrapper section-gap">

			<!-- Табы (вкладки) -->
			<div class="faq-tabs">
				<ul class="faq-tabs__list courses-tabs">
					<?php foreach ($faq_posts as $index => $faq_post):
						$is_active = ($index === 0);
						?>
						<li class="faq-tabs__item courses-tabs__item">
							<button class="faq-tabs__btn courses-tabs__btn <?php echo $is_active ? 'active' : ''; ?>"
								type="button" data-faq-tab="<?php echo esc_attr($faq_post->ID); ?>">
								<?php echo esc_html(get_the_title($faq_post->ID)); ?>
							</button>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Контент табов -->
			<div class="faq-tabs__content">
				<?php foreach ($faq_posts as $index => $faq_post):
					$post_id = $faq_post->ID;
					$is_active = ($index === 0);

					// Получаем поля ACF для этой вкладки
					$faq_image = get_field('faq_image', $post_id) ?? null;
					$questions = get_field('faq_questions', $post_id) ?? [];
					?>
					<div class="faq-tab-panel <?php echo $is_active ? 'active' : ''; ?>"
						data-faq-panel="<?php echo esc_attr($post_id); ?>">

						<div class="section-faq__wrapper">

							<!-- Изображение слева -->
							<?php if ($faq_image && is_array($faq_image) && !empty($faq_image['ID'])): ?>
								<div class="section-faq__image image-box jarallax hidden-mobile">
									<?php echo wp_get_attachment_image(
										$faq_image['ID'],
										'large',
										false,
										[
											'class' => 'img jarallax-img',
											'alt' => $faq_image['alt'] ?: get_the_title($post_id),
											'loading' => 'lazy',
										]
									); ?>
								</div>
							<?php endif; ?>

							<!-- Список вопросов -->
							<?php if (!empty($questions) && is_array($questions)): ?>
								<ul class="section-faq__list">
									<?php foreach ($questions as $faq):
										$faq_title = $faq['question'] ?? '';
										$faq_answer = $faq['answer'] ?? '';
										$is_faq_active = !empty($faq['is_active']);

										$item_classes = ['faq__item', 'faq-item'];
										if ($is_faq_active) {
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
							<?php else: ?>
								<p class="text-small">В этой вкладке пока нет вопросов.</p>
							<?php endif; ?>

						</div>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>