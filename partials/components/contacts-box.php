<?php 
$page = 'options';

$phones = get_field('contacts_phones', $page) ?? [];
$emails = get_field('contacts_emails', $page) ?? [];
$address = get_field('contacts_address', $page) ?? '';
$time = get_field('contacts_time', $page) ?? '';
?>
<div class="contacts-box">
	<?php if (!empty($phones)): ?>
		<div class="contacts-box__item icon icon--phone">
			<div class="contacts-box__content">
				<h3 class="label contacts-box__title">
					Телефон
				</h3>
				<ul class="contacts-box__list">
					<?php foreach ($phones as $phone): ?>
						<li class="contacts-box__subitem">
							<a class="contacts-box__link link" href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])) ?>">
								<?php echo esc_html($phone['phone']) ?>
							</a>
							<?php if (!empty($messengers = $phone['messengers'])): ?>
								<ul class="contacts-box__sublist messengers">
									<?php foreach ($messengers as $msg): ?>
										<li class="messengers__item">
											<a class="messengers__link link-icon" href="<?= esc_attr($msg['link']['url']) ?>" target="_blank">
												<?php echo wp_get_attachment_image(
													$msg['image']['ID'],
													'large',
													false,
													array(
														'class' => 'img',
														'alt' => $msg['image']['alt'] ?: $msg['link']['title']
													)
												); ?>
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
	<?php if (!empty($emails)): ?>
		<div class="contacts-box__item icon icon--email">
			<div class="contacts-box__content">
				<h3 class="label contacts-box__title">
					E-mail
				</h3>
				<ul class="contacts-box__list">
					<?php foreach ($emails as $email): ?>
						<li class="contacts-box__item">
							<a class="contacts-box__link link" href="tel:+<?php echo esc_attr($email['email']) ?>">
								<?php echo esc_html($email['email']) ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($address)): ?>
		<div class="contacts-box__item icon icon--address">
			<div class="contacts-box__content">
				<h3 class="label contacts-box__title">
					Адрес
				</h3>
				<address class="contacts-box__descr descr">
					<?php echo wp_kses_post($address) ?>
				</address>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($time)): ?>
		<div class="contacts-box__item icon icon--time">
			<div class="contacts-box__content">
				<h3 class="label contacts-box__title">
					Режим работы
				</h3>
				<div class="contacts-box__descr descr">
					<?php echo wp_kses_post($time) ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>