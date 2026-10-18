<?php
$post_id = get_the_ID();

// Заголовок секции можно передать через $args или оставить по умолчанию
$label = get_field('course_audience_label', $post_id) ?? 'Для кого';
$title = get_field('course_audience_title', $post_id) ?? 'Кому подойдёт курс';

$audiences = get_field('course_audience_items', $post_id) ?? [];

// Если нет ни одной аудитории — не выводим секцию
if (empty($audiences)) {
	return;
}

// Дефолтная иконка (если у конкретной аудитории иконка не загружена)
$default_icon = get_template_directory_uri() . '/assets/images/about-block-card.svg';
?>

<section class="section course-audience" id="course-audience">
	<div class="container course-audience__container section-gap">

		<!-- Заголовок секции -->
		<?php get_template_part('partials/section-header', null, [
			'label' => $label,
			'title' => $title,
		]); ?>

		<!-- Список аудиторий -->
		<ul class="course-audience__list grid">
			<?php foreach ($audiences as $audience):
				$icon = $audience['icon'] ?? null;
				$audience_title = $audience['title'] ?? '';
				$audience_descr = $audience['descr'] ?? '';

				// Определяем URL иконки
				$icon_url = $default_icon;
				$icon_alt = $audience_title;
				if ($icon && is_array($icon) && !empty($icon['ID'])) {
					$icon_url = $icon['url'] ?? $default_icon;
					$icon_alt = $icon['alt'] ?: $audience_title;
				}
				?>
				<li class="course-audience__item course-audience-item">

					<!-- Иконка -->
					<div class="course-audience-item__icon">
						<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" loading="lazy" />
					</div>

					<!-- Контент -->
					<div class="course-audience-item__content">
						<?php if ($audience_title): ?>
							<h3 class="course-audience-item__title title-3">
								<?php echo esc_html($audience_title); ?>
							</h3>
						<?php endif; ?>

						<?php if ($audience_descr): ?>
							<div class="course-audience-item__descr descr text-small">
								<?php echo wp_kses_post($audience_descr); ?>
							</div>
						<?php endif; ?>
					</div>

				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>