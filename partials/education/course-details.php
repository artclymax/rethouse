<?php

$post_id = get_the_ID();

// Собираем все детали в массив
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
$event_start_time = get_field('event_start_time', $post_id);
$event_end_time = get_field('event_end_time', $post_id);
if ($event_start_time || $event_end_time) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/clock.svg',
		'icon' => 'clock',
		'title' => 'Время:',
		'descr' => $event_start_time . '-' . $event_end_time,
	];
}

// 3. Формат
$event_format = get_field('event_format', $post_id);
if ($event_format) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/format.svg',
		'icon' => 'format',
		'title' => 'Формат:',
		'descr' => $event_format,
	];
}

// 4. Место
$event_location = get_field('event_location', $post_id);
if ($event_location) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/location.svg',
		'icon' => 'location',
		'title' => 'Место:',
		'descr' => $event_location,
	];
}

// 5. Стоимость
$event_price = get_field('event_price', $post_id);
if ($event_price) {
	$details[] = [
		'icon_url' => get_template_directory_uri() . '/assets/images/icons/price.svg',
		'icon' => 'price',
		'title' => 'Стоимость:',
		'descr' => $event_price,
	];
}

// Если нет ни одной заполненной детали — не выводим секцию
if (empty($details)) {
	return;
}

// Путь к дефолтной иконке (замените на свой путь, если нужно)
$default_icon = get_template_directory_uri() . '/assets/images/about-block-card.svg';
?>

<section class="course-details" id="course-details">
	<div class="container course-details__container">
		<ul class="course-details__list grid">
			<?php foreach ($details as $detail): ?>
				<li class="course-details__item course-details-item icon icon--<?= $detail['icon'] ?? 'default'; ?>"
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
	</div>
</section>