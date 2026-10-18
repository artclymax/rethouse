<?php
/**
 * Template Part: Course Programs and Results Section
 * Description: Секция с результатами обучения и программой курса
 * Используется на single-education_career.php
 */

$post_id = get_the_ID();

// ==================== БЛОК РЕЗУЛЬТАТОВ ====================
$results_label = get_field('results_label', $post_id) ?? 'Навыки и результат';
$results_title = get_field('results_title', $post_id) ?? 'Чему вы научитесь на курсе';
$skills = get_field('skills_list', $post_id) ?? [];
$price = get_field('event_price', $post_id) ?? '';
$enroll_btn = get_field('enroll_btn', $post_id) ?? null;

// ==================== БЛОК ПРОГРАММЫ ====================
$programs_label = get_field('programs_label', $post_id) ?? 'ПРОГРАММА';
$programs_title = get_field('programs_title', $post_id) ?? '';
$programs = get_field('programs_list', $post_id) ?? [];

// Если нет ни навыков, ни программы — не выводим секцию
if (empty($skills) && empty($programs)) {
	return;
}

// Формируем данные кнопки
$btn_url = '#enroll';
$btn_title = 'Записаться на курс';
$btn_target = '_self';

if ($enroll_btn && !empty($enroll_btn['url'])) {
	$btn_url = $enroll_btn['url'];
	$btn_title = $enroll_btn['title'];
	$btn_target = !empty($enroll_btn['target']) ? $enroll_btn['target'] : '_self';
}
?>

<section class="section course-programs-and-results" id="course-programs-and-results">
	<div class="container course-programs-and-results__container">

		<!-- ==================== БЛОК РЕЗУЛЬТАТОВ ==================== -->
		<?php if (!empty($skills) || $price): ?>
			<div class="course-programs-and-results__results course-results">
				<div class="course-results__card card-box">

					<!-- Заголовок блока результатов -->
					<div class="course-results__header">
						<span class="course-results__label label">
							<?php echo esc_html($results_label); ?>
						</span>
						<h2 class="course-results__title title-3">
							<?php echo esc_html($results_title); ?>
						</h2>
					</div>

					<!-- Список навыков -->
					<?php if (!empty($skills) && is_array($skills)): ?>
						<ul class="course-results__list">
							<?php foreach ($skills as $skill):
								$skill_text = $skill['skill_text'] ?? '';
								if (!$skill_text)
									continue;
								?>
								<li class="course-results__item descr icon icon--check-list">
									<?php echo esc_html($skill_text); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<!-- Блок с ценой -->
					<?php if ($price): ?>
						<div class="course-results__price icon icon--price" style="--icon-bg: url('<?= esc_url(get_template_directory_uri(  ) . '/assets/images/icons/price.svg')?>');">
							<div class="course-results__price-box">
								<span class="course-results__price-label text-btn">Стоимость:</span>
								<span class="course-results__price-value title-3">
									<?php echo esc_html($price); ?>
								</span>
							</div>
						</div>
					<?php endif; ?>

				</div>

				<!-- Кнопка записи -->
				<?php if ($btn_url): ?>
					<a class="course-results__btn btn" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="<?php echo esc_attr($btn_target); ?>" <?php endif; ?> data-modal-input-btn="<?php echo esc_attr(get_the_title($post_id)); ?>">
						<?php echo esc_html($btn_title); ?>
					</a>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<!-- ==================== БЛОК ПРОГРАММЫ ==================== -->
		<?php if (!empty($programs) && is_array($programs)): ?>
			<div class="course-programs-and-results__programs course-programs">

				<!-- Заголовок блока программы -->
				<div class="course-programs__header">
					<span class="course-programs__label label">
						<?php echo esc_html($programs_label); ?>
					</span>
					<?php if ($programs_title): ?>
						<h2 class="course-programs__title title-3">
							<?php echo esc_html($programs_title); ?>
						</h2>
					<?php endif; ?>
				</div>

				<!-- Список занятий -->
				<ul class="course-programs__list">
					<?php foreach ($programs as $index => $program):
						$program_title = $program['title'] ?? '';
						$program_descr = $program['descr'] ?? '';
						$program_image = $program['image'] ?? null;

						// Автоматическая нумерация: 01, 02, 03...
						$number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);

						if (!$program_title)
							continue;
						?>
						<li class="course-programs__item program-card card-box">

							<!-- Номер занятия -->
							<div class="program-card__number title-2">
								<?php echo esc_html($number); ?>
							</div>

							<!-- Контент занятия -->
							<div class="program-card__content">
								<h3 class="program-card__title text-btn">
									<?php echo esc_html($program_title); ?>
								</h3>
								<?php if ($program_descr): ?>
									<div class="program-card__descr descr text-small">
										<?php echo wp_kses_post($program_descr); ?>
									</div>
								<?php endif; ?>
							</div>

							<!-- Изображение занятия -->
							<?php if ($program_image && is_array($program_image) && !empty($program_image['ID'])): ?>
								<div class="program-card__image image-box">
									<?php echo wp_get_attachment_image(
										$program_image['ID'],
										'medium_large',
										false,
										[
											'class' => 'img',
											'alt' => $program_image['alt'] ?: $program_title,
											'loading' => 'lazy',
										]
									); ?>
								</div>
							<?php endif; ?>

						</li>
					<?php endforeach; ?>
				</ul>

			</div>
		<?php endif; ?>

	</div>
</section>