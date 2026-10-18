<?php

// Инициализация переменных
$resident_id = get_the_ID();
$label = get_field('resident_contacts_label', $resident_id) ?? 'Как связаться';
$title = get_field('resident_contacts_title', $resident_id) ?? 'Контакты резидента';
$phones = get_field('resident_contacts_phones', $resident_id) ?? [];
$email = get_field('resident_contacts_email', $resident_id) ?? '';
$address = get_field('resident_contacts_address', $resident_id) ?? '';
$website = get_field('resident_contacts_website', $resident_id) ?? '';
$socials = get_field('resident_contacts_socials', $resident_id) ?? [];
$map = get_field('resident_contacts_map', $resident_id) ?? '';

$has_content = (!empty($phones) || $email || $address || $website || !empty($socials) || $map);

if ($has_content):
	?>
	<section class="section residents-contacts" id="residents-contacts">
		<div class="container residents-contacts__container section-gap">

			<?php if ($title): ?>
				<?php get_template_part('partials/section-header', null, [
					'label' => $label,
					'title' => $title,
				]); ?>
			<?php endif; ?>

			<div class="residents-contacts__wrapper">

				<!-- Левая часть: контактная информация -->
				<div class="residents-contacts__grid">

					<!-- Телефоны -->
					<?php if (!empty($phones)): ?>
						<div class="residents-contacts__item contacts-item">
							<div class="contacts-item__icon icon icon--phone">
							</div>
							<?php foreach ($phones as $phone):
								$phone_number = $phone['phone_number'] ?? '';
								$phone_name = $phone['phone_name'] ?? '';
								if (!$phone_number)
									continue;
								$phone_clean = preg_replace('/[^0-9+]/', '', $phone_number);
								?>

								<div class="contacts-item__content">
									<a class="contacts-item__link link" href="tel:<?php echo esc_attr($phone_clean); ?>">
										<?php echo esc_html($phone_number); ?>
									</a>
									<?php if ($phone_name): ?>
										<span class="contacts-item__name">
											<?php echo esc_html($phone_name); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<!-- Email -->
					<?php if ($email): ?>
						<div class="residents-contacts__item contacts-item">
							<div class="contacts-item__icon icon icon--email">
							</div>
							<div class="contacts-item__content">
								<a class="contacts-item__link link" href="mailto:<?php echo esc_attr($email); ?>">
									<?php echo esc_html($email); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>

					<!-- Адрес -->
					<?php if ($address): ?>
						<div class="residents-contacts__item contacts-item">
							<div class="contacts-item__icon icon icon--address">
							</div>
							<div class="contacts-item__content">
								<address class="contacts-item__text descr">
									<?php echo wp_kses_post($address); ?>
								</address>
							</div>
						</div>
					<?php endif; ?>

					<!-- Сайт -->
					<?php if ($website): ?>
						<div class="residents-contacts__item contacts-item">
							<div class="contacts-item__icon icon icon--website">
							</div>
							<div class="contacts-item__content">
								<a class="contacts-item__link link" href="<?php echo esc_url($website); ?>" target="_blank"
									rel="noopener noreferrer">
									<?php echo esc_html($website); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($socials)): ?>
						<div class="residents-contacts__item residents-contacts__item--big contacts-item">
							<div class="contacts-item__icon icon icon--social">
							</div>
							<div class="residents-contacts__socials socials-list">
								<?php foreach ($socials as $social):
									$social_icon = $social['social_icon'] ?? null;
									$social_url = $social['social_url'] ?? [];

									if (!$social_url)
										continue;
									?>
									<a class="socials-list__link link-icon" href="<?php echo esc_url($social_url['url']); ?>"
										target="_blank" rel="noopener noreferrer"
										aria-label="Перейти в социальную сеть <?php echo esc_attr($social_url['title']); ?>">

										<?php if ($social_icon && is_array($social_icon) && !empty($social_icon['ID'])): ?>
											<?php echo wp_get_attachment_image(
												$social_icon['ID'],
												'full',
												false,
												[
													'class' => 'img',
													'alt' => $social_icon['alt'] ?: 'Социальная сеть',
													'loading' => 'lazy'
												]
											); ?>
										<?php endif; ?>

									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Правая часть: карта -->
				<?php if ($map): ?>
					<div class="residents-contacts__map">
						<?php
						echo wp_kses($map, [
							'iframe' => [
								'src' => true,
								'width' => true,
								'height' => true,
								'style' => true,
								'allowfullscreen' => true,
								'loading' => true,
								'frameborder' => true,
							],
						]);
						?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>