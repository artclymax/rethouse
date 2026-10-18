<?php
/**
 * Template Part: Course CTA Section
 * Description: Финальный блок с призывом к действию и дублированием ключевых деталей курса
 */

$post_id = get_the_ID();

// ==================== 1. ПОЛУЧАЕМ CTA ПОЛЯ ====================
$cta_title = get_field('course_cta_title', $post_id) ?: 'Хотите записаться на курс?';
$cta_descr = get_field('course_cta_descr', $post_id) ?: 'Оставьте заявку — мы свяжемся с вами, расскажем подробности и подтвердим участие.';
$cta_btn = get_field('course_cta_btn', $post_id) ?? null;
$cta_image = get_field('course_cta_image', $post_id) ?? null;

// ==================== 2. СОБИРАЕМ ДЕТАЛИ (ВАША ЛОГИКА + РАСПИСАНИЕ) ====================
$details = [];

// 1. Дата начала
$event_date = get_field('event_start_date', $post_id);
if ($event_date) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/calendar.svg',
		'icon' => 'calendar',
		'title' => 'Старт:',
		'descr' => $event_date,
	];
}

// 2. Длительность
$event_duration = get_field('event_duration', $post_id);
if ($event_duration) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/clock.svg',
		'icon' => 'clock',
		'title' => 'Длительность:',
		'descr' => $event_duration,
	];
}

$event_schedule = get_field('event_schedule', $post_id);
if ($event_schedule) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/schedule.svg', // или clock.svg
		'icon' => 'schedule',
		'title' => 'Расписание:',
		'descr' => $event_schedule,
	];
}

// 4. Формат
$event_format = get_field('event_format', $post_id);
if ($event_format) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/format.svg',
		'icon' => 'format',
		'title' => 'Формат:',
		'descr' => $event_format,
	];
}

// 5. Место
$event_location = get_field('event_location', $post_id);
if ($event_location) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/location.svg',
		'icon' => 'location',
		'title' => 'Место:',
		'descr' => $event_location,
	];
}

// 6. Стоимость
$event_price = get_field('event_price', $post_id);
if ($event_price) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/price.svg',
		'icon' => 'price',
		'title' => 'Стоимость:',
		'descr' => $event_price,
	];
}

// Если нет ни деталей, ни картинки — не выводим секцию
if (empty($details) && !$cta_image) {
	return;
}

// Данные кнопки
$btn_url = '#enroll';
$btn_title = 'Записаться на курс';
$btn_target = '_self';

if ($cta_btn && !empty($cta_btn['url'])) {
	$btn_url = $cta_btn['url'];
	$btn_title = $cta_btn['title'];
	$btn_target = !empty($cta_btn['target']) ? $cta_btn['target'] : '_self';
}
?>

<section class="section course-cta" id="course-cta">
	<div class="container course-cta__container">
		<div class="course-cta__body">

			<!-- Левая часть: Контент и кнопка -->
			<div class="course-cta__content">
				<h2 class="course-cta__title title-2">
					<?php echo esc_html($cta_title); ?>
				</h2>
				<?php if ($cta_descr): ?>
					<p class="course-cta__descr descr">
						<?php echo esc_html($cta_descr); ?>
					</p>
				<?php endif; ?>

				<a class="course-cta__btn btn" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="
					<?php echo esc_attr($btn_target); ?>" <?php endif; ?>
					data-modal-input-btn="<?php echo esc_attr(get_the_title($post_id)); ?>">
					<?php echo esc_html($btn_title); ?>
				</a>
			</div>

			<?php if (!empty($details)): ?>
				<ul class="course-details__list">
					<?php foreach ($details as $detail): ?>
						<li class="course-details__item course-details-item icon icon--<?= esc_attr($detail['icon'] ?? 'default'); ?>"
							style="--icon-bg: url('<?= esc_url($detail['icon_url'] ?? '') ?>')">
							<div class="course-details-item__content">
								<h3 class="course-details-item__title text-btn">
									<?php echo esc_html($detail['title']); ?>
								</h3>
								<div class="course-details-item__descr descr text-small">
									<?php echo esc_html($detail['descr']); ?>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<!-- Правая часть: Изображение -->
			<?php if ($cta_image && is_array($cta_image) && !empty($cta_image['ID'])): ?>
				<div class="course-cta__image image-box">
					<?php echo wp_get_attachment_image(
						$cta_image['ID'],
						'large',
						false,
						[
							'class' => 'img',
							'alt' => $cta_image['alt'] ?: $cta_title,
							'loading' => 'lazy',
						]
					); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>