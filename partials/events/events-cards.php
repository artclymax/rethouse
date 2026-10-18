<?php
$post_id = get_the_ID();

// ==================== ДАННЫЕ ЭКСПЕРТА ====================
$expert_image = get_field('expert_image', $post_id) ?? null;
$expert_label = get_field('expert_label', $post_id) ?? 'Встречу проводит';
$expert_name = get_field('expert_name', $post_id) ?? '';
$expert_about = get_field('expert_about', $post_id) ?? '';
$expert_descr = get_field('expert_descr', $post_id) ?? '';

// ==================== ДАННЫЕ РАСПИСАНИЯ ====================
$schedule_title = get_field('schedule_title', $post_id) ?? 'Что будет на встрече?';
$schedule_items = get_field('schedule_items', $post_id) ?? [];

// Если нет ни эксперта, ни расписания — не выводим секцию
if (!$expert_name && empty($schedule_items)) {
	return;
}
?>

<section class="section events-cards" id="events-cards">
	<div class="container events-cards__container">
		<div class="events-cards__wrapper">

			<!-- ==================== БЛОК ЭКСПЕРТА ==================== -->
			<?php if ($expert_name): ?>
				<div class="events-cards__expert expert-card">

					<!-- Фото -->
					<?php if ($expert_image && is_array($expert_image) && !empty($expert_image['ID'])): ?>
						<div class="expert-card__image image-box">
							<?php echo wp_get_attachment_image(
								$expert_image['ID'],
								'medium_large',
								false,
								[
									'class' => 'img',
									'alt' => $expert_image['alt'] ?: $expert_name,
									'loading' => 'lazy',
								]
							); ?>
						</div>
					<?php endif; ?>

					<!-- Контент -->
					<div class="expert-card__content">

						<!-- Метка -->
						<?php if ($expert_label): ?>
							<span class="expert-card__label label">
								<?php echo esc_html($expert_label); ?>
							</span>
						<?php endif; ?>

						<!-- Имя -->
						<?php if ($expert_name): ?>
							<h3 class="expert-card__title title-3">
								<?php echo esc_html($expert_name); ?>
							</h3>
						<?php endif; ?>

						<!-- Должность -->
						<?php if ($expert_about): ?>
							<p class="expert-card__about text-small">
								<?php echo esc_html($expert_about); ?>
							</p>
						<?php endif; ?>

						<!-- Описание -->
						<?php if ($expert_descr): ?>
							<div class="expert-card__descr descr">
								<p>
									<?php echo wp_kses_post($expert_descr); ?>
								</p>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>

			<!-- ==================== БЛОК РАСПИСАНИЯ ==================== -->
			<?php if (!empty($schedule_items) && is_array($schedule_items)): ?>
				<div class="events-cards__schedule schedule-card">

					<!-- Заголовок -->
					<?php if ($schedule_title): ?>
						<h3 class="schedule-card__title title-3">
							<?php echo esc_html($schedule_title); ?>
						</h3>
					<?php endif; ?>

					<!-- Список пунктов -->
					<ul class="schedule-card__list">
						<?php foreach ($schedule_items as $item):
							$item_time = $item['time'] ?? '';
							$item_title = $item['title'] ?? '';
							if (!$item_title)
								continue;
							?>
							<li class="schedule-card__item">
								<?php if ($item_time): ?>
									<span class="schedule-card__time">
										<?php echo esc_html($item_time); ?>
									</span>
								<?php endif; ?>
								<span class="schedule-card__dot"></span>
								<span class="schedule-card__text">
									<?php echo esc_html($item_title); ?>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
			<?php endif; ?>

		</div>
	</div>
</section>