<?php
$page = 'option';

$btn = get_field('header_btn', $page) ?? [];
$header_phone = get_field('header_phone', $page) ?: get_field('contacts_phones', $page)[0]['phone'] ?? [];
$address = get_field('contacts_address', $page) ?? '';
$phones = get_field('contacts_phones', $page) ?? [];
$class = $args['class'] ?? '';
?>

<header class="header <?= esc_attr($class) ?>" data-auto-calc="header, height">
	<div class="container header__container">
		<div class="header__body">
			<div class="header__logo logo">
				<?php mx_logo(); ?>
			</div>
			<nav class="header__menu header-menu">
				<div class="header-menu__contacts header-contacts">
					<?php if (!empty($address)): ?>
						<div class="header-contacts__block icon icon--address-accent">
							<address class="header-contacts__address descr">
								<?php echo wp_kses_post($address) ?>
							</address>
						</div>
					<?php endif; ?>
					<?php if (!empty($phones)): ?>
						<div class="header-contacts__block icon icon--phone-accent">
							<ul class="header-contacts__phones contacts-box__list">
								<?php foreach ($phones as $phone): ?>
									<li class="contacts-box__subitem">
										<a class="contacts-box__link link"
											href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])) ?>">
											<?php echo esc_html($phone['phone']) ?>
										</a>
										<?php if (!empty($messengers = $phone['messengers'])): ?>
											<ul class="contacts-box__sublist messengers">
												<?php foreach ($messengers as $msg): ?>
													<li class="messengers__item">
														<a class="messengers__link link-icon" href="<?= esc_attr($msg['link']['url']) ?>"
															target="_blank">
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
					<?php endif; ?>
				</div>
				<div class="header-menu__btn-box">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'wishlist-menu',
						'container' => false,
						'menu_class' => 'wishlist-menu',
						'fallback_cb' => false,
						'depth' => 1
					));
					?>
					<?php if (!empty($btn)): ?>
						<a class="header-menu__btn btn btn--accent" href="<?php echo esc_url($btn['url']) ?>">
							<?php echo esc_html($btn['title']) ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="header-menu__main-menu">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'header-menu',
						'container' => false,
						'menu_class' => 'header-menu__list',
						'fallback_cb' => false,
						'depth' => 1
					));
					?>
				</div>
			</nav>
			<!-- phone -->
			<a class="header__phone-btn phone-btn visible-tablet" aria-label="Позвонить"
				href="tel:+<?php echo esc_attr(correct_phone($header_phone)) ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M18.3334 14.1V16.6C18.3344 16.8321 18.2868 17.0618 18.1939 17.2745C18.1009 17.4871 17.9645 17.678 17.7935 17.8349C17.6225 17.9918 17.4206 18.1112 17.2007 18.1856C16.9809 18.26 16.7479 18.2876 16.5168 18.2667C13.9525 17.988 11.4893 17.1118 9.32511 15.7083C7.31163 14.4289 5.60455 12.7218 4.32511 10.7083C2.91676 8.53435 2.04031 6.05917 1.76677 3.48334C1.74595 3.2529 1.77334 3.02064 1.84719 2.80136C1.92105 2.58208 2.03975 2.38058 2.19575 2.20969C2.35174 2.0388 2.54161 1.90227 2.75327 1.80878C2.96492 1.71529 3.19372 1.66689 3.42511 1.66668H5.92511C6.32953 1.6627 6.7216 1.80591 7.02824 2.06962C7.33488 2.33333 7.53517 2.69955 7.59177 3.10001C7.69729 3.90006 7.89298 4.68562 8.17511 5.44168C8.28723 5.73995 8.31149 6.0641 8.24503 6.37574C8.17857 6.68738 8.02416 6.97344 7.80011 7.20001L6.74177 8.25834C7.92807 10.3446 9.65549 12.072 11.7418 13.2583L12.8001 12.2C13.0267 11.976 13.3127 11.8216 13.6244 11.7551C13.936 11.6886 14.2602 11.7129 14.5584 11.825C15.3145 12.1071 16.1001 12.3028 16.9001 12.4083C17.3049 12.4655 17.6746 12.6693 17.9389 12.9813C18.2032 13.2932 18.3436 13.6913 18.3334 14.1Z"
						stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</a>
			<!-- wishlist -->
			<?php
			wp_nav_menu(array(
				'theme_location' => 'wishlist-menu',
				'container' => false,
				'menu_class' => 'wishlist-mobile-btn visible-tablet',
				'fallback_cb' => false,
				'depth' => 1
			));
			?>
			<!-- BURGER -->
			<button class="header__burger-btn burger-btn visible-tablet" type="button" aria-label="Открыть/закрыть меню">
				<span></span>
			</button>
		</div>
	</div>
</header>