<?php

$page_id = 'option' ?? '';

// Получаем поля ACF
$address = get_field('contacts_address', $page_id) ?? '';
$phones = get_field('contacts_phones', $page_id) ?? [];
$emails = get_field('contacts_emails', $page_id) ?? [];
$schedule = get_field('contacts_time', $page_id) ?? '';
$map = get_field('contacts_map', $page_id) ?? '';
$scenarios = get_field('contacts_scenarios', $page_id) ?? [];
$socials_title = get_field('contacts_socials_title', $page_id) ?? 'Мы в соцсетях';
$socials_descr = get_field('contacts_socials_descr', $page_id) ?? '';
$socials = get_field('contacts_socials', $page_id) ?? [];

?>

<section class="section contacts-page contacts-cta" id="contacts-cta">
	<div class="container contacts-cta__container">

		<!-- ==================== БЛОК КОНТАКТОВ ==================== -->
		<div class="contacts-cta__contacts-list-box contacts-list-box grid">

			<!-- Адрес -->
			<?php if ($address): ?>
				<div class="contacts-list-box__card icon icon--address-accent">
					<div class="contacts-list-box__content">
						<h3 class="contacts-list-box__title text-small">Адрес</h3>
						<address class="contacts-list-box__descr descr">
							<?php echo wp_kses_post($address); ?>
						</address>
					</div>
				</div>
			<?php endif; ?>

			<!-- Телефоны -->
			<?php if (!empty($phones)): ?>
				<div class="contacts-list-box__card icon icon--phone-accent">
					<div class="contacts-list-box__content">
						<h3 class="contacts-list-box__title text-small">Телефон</h3>
						<ul class="contacts-list-box__list">
							<?php foreach ($phones as $phone):
								$phone_number = $phone['phone'] ?? '';
								$messengers = $phone['messengers'] ?? [];
								if (!$phone_number)
									continue;

								$phone_clean = preg_replace('/[^0-9+]/', '', $phone_number);
								?>
								<li class="contacts-list-box__item">
									<a class="contacts-list-box__link link" href="tel:<?php echo esc_attr($phone_clean); ?>">
										<?php echo esc_html($phone_number); ?>
									</a>
									<?php if (!empty($messengers)): ?>
										<ul class="contacts-list-box__sublist social-links">
											<?php foreach ($messengers as $messenger):
												$messenger_icon = $messenger['image'] ?? null;
												$messenger_url = $messenger['link'] ?? '';
												if (!$messenger_url)
													continue;
												?>
												<li class="social-links__item">
													<a class="social-links__link link-icon" href="<?php echo esc_url($messenger_url['url']); ?>"
														target="_blank" rel="noopener noreferrer">
														<?php if ($messenger_icon && is_array($messenger_icon) && !empty($messenger_icon['ID'])): ?>
															<?php echo wp_get_attachment_image(
																$messenger_icon['ID'],
																'thumbnail',
																false,
																[
																	'class' => 'img',
																	'alt' => $messenger_url['title'] ?? $messenger_icon['alt'] ?: 'Мессенджер',
																]
															); ?>
														<?php endif; ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>

			<!-- Email -->
			<?php if (!empty($emails)): ?>
				<div class="contacts-list-box__card icon icon--mail-accent">
					<div class="contacts-list-box__content">
						<h3 class="contacts-list-box__title text-small">E-mail</h3>
						<ul class="contacts-list-box__list">
							<?php foreach ($emails as $email):
								$email_address = $email['email'] ?? '';
								if (!$email_address)
									continue;
								?>
								<li class="contacts-list-box__item">
									<a class="contacts-list-box__link link" href="mailto:<?php echo esc_attr($email_address); ?>">
										<?php echo esc_html($email_address); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>

			<!-- Режим работы -->
			<?php if ($schedule): ?>
				<div class="contacts-list-box__card icon icon--time-accent">
					<div class="contacts-list-box__content">
						<h3 class="contacts-list-box__title text-small">Режим работы</h3>
						<div class="contacts-list-box__descr descr">
							<?php echo wp_kses_post($schedule); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		<!-- ==================== БЛОК С КАРТОЙ И СЦЕНАРИЯМИ ==================== -->
		<div class="contacts-cta__body">

			<!-- Карта -->
			<?php if ($map): ?>
				<div class="contacts-cta__map">
					<?php echo wp_kses($map, [
						'iframe' => [
							'src' => true,
							'width' => true,
							'height' => true,
							'style' => true,
							'allowfullscreen' => true,
							'loading' => true,
						],
					]) ?>
				</div>
			<?php endif; ?>

			<!-- Быстрые сценарии -->
			<?php if (!empty($scenarios)): ?>
				<div class="contacts-cta__scenarios scenarios">
					<h3 class="scenarios__title title-3">Быстрые сценарии</h3>
					<ul class="scenarios__list">
						<?php foreach ($scenarios as $scenario):
							$scenario_icon = $scenario['icon'] ?? null;
							$scenario_link = $scenario['link'] ?? null;

							$link_url = '';
							$link_title = '';
							$link_target = '_self';

							if ($scenario_link && !empty($scenario_link['url'])) {
								$link_url = $scenario_link['url'];
								$link_title = $scenario_link['title'];
								$link_target = !empty($scenario_link['target']) ? $scenario_link['target'] : '_self';
							}

							if (!$link_url)
								continue;
							?>
							<li class="scenarios__item scenarios-item">
								<a class="scenarios-item__link-wrapper" href="<?php echo esc_url($link_url); ?>" <?php if ($link_target !== '_self'): ?>target="
							<?php echo esc_attr($link_target); ?>" <?php endif; ?>>
									<div class="scenarios-item__icon">
										<?php if ($scenario_icon && is_array($scenario_icon) && !empty($scenario_icon['ID'])): ?>
											<?php echo wp_get_attachment_image(
												$scenario_icon['ID'],
												'thumbnail',
												false,
												[
													'class' => 'img',
													'alt' => $scenario_icon['alt'] ?: $link_title,
												]
											); ?>
										<?php endif; ?>
									</div>
									<p class="scenarios-item__text text-btn icon icon--after icon--arrow-right">
										<?php echo esc_html($link_title); ?>
									</p>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

		</div>

		<!-- ==================== БЛОК СОЦСЕТЕЙ ==================== -->
		<?php if (!empty($socials)): ?>
			<div class="contacts-cta__socials socials">
				<div class="socials__header">
					<h3 class="socials__title title-3">
						<?php echo esc_html($socials_title); ?>
					</h3>
					<?php if ($socials_descr): ?>
						<div class="socials__descr descr">
							<?php echo wp_kses_post($socials_descr); ?>
						</div>
					<?php endif; ?>
				</div>
				<ul class="socials__list socials-list-cards">
					<?php foreach ($socials as $social):
						$social_icon = $social['icon'] ?? null;
						$social_text = $social['text'] ?? '';
						$social_url = $social['url'] ?? '';
						if (!$social_url)
							continue;
						?>
						<li class="socials-list-cards__item">
							<a class="socials-list-cards__link" href="<?php echo esc_url($social_url['url']); ?>" target="_blank"
								rel="noopener noreferrer">
								<div class="socials-list-cards__icon">
									<?php if ($social_icon && is_array($social_icon) && !empty($social_icon['ID'])): ?>
										<?php echo wp_get_attachment_image(
											$social_icon['ID'],
											'thumbnail',
											false,
											[
												'class' => 'img',
												'alt' => $social_icon['alt'] ?: $social_text,
											]
										); ?>
									<?php endif; ?>
								</div>
								<span class="socials-list-cards__text text-btn">
									<?php echo esc_html($social_text); ?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

	</div>
</section>