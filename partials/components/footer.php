<?php
/**
 * Template: Footer
 * Description: Футер сайта (desktop версия)
 */

// Инициализация переменных (Options Page)
$page = 'options';
$descr = get_field('footer_descr', $page) ?: get_bloginfo('description') ?? '';
$copy = get_field('footer_copy', $page) ?? '';
$links = get_field('footer_links', $page) ?? [];
$company = get_field('footer_company', $page) ?: get_bloginfo('name') ?? '';

// Подписка
$subscribe_descr = get_field('footer_subscribe_descr', $page) ?? '';
$subscribe_form = get_field('footer_subscribe_form', $page) ?? '';
$subscribe_note = get_field('footer_subscribe_note', $page) ?? '';

// Защитная обёртка
$has_footer = (
	$descr || $company || $copy ||
	!empty($links) || $subscribe_descr || $subscribe_form
);

if ($has_footer):
	?>
	<footer class="footer" id="footer">
		<div class="footer__container container">

			<!-- TOP: 4 колонки -->
			<div class="footer__top">

				<!-- INFO -->
				<div class="footer__info">
					<div class="footer__logo logo">
						<?php mx_logo(); ?>
					</div>
					<?php if ($descr): ?>
						<div class="footer__descr descr label visible-tablet">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- MENU -->
				<nav class="footer__menu footer-col">
					<h3 class="footer-col__title text-btn">Навигация</h3>
					<?php
					wp_nav_menu([
						'theme_location' => 'footer-menu',
						'container' => false,
						'menu_class' => 'footer-menu',
						'depth' => 1,
						'fallback_cb' => false,
					]);
					?>
				</nav>

				<!-- CONTACTS -->
				<div class="footer__menu footer-col">
					<h3 class="footer-col__title text-btn">Контакты</h3>
					<?php get_template_part('partials/components/contacts-box'); ?>
				</div>

				<!-- SUBSCRIBE -->
				<div class="footer__menu footer-col">
					<h3 class="footer-col__title text-btn">Подписка</h3>

					<?php if ($subscribe_descr): ?>
						<div class="footer-col__descr descr">
							<?php echo wp_kses_post($subscribe_descr); ?>
						</div>
					<?php endif; ?>

					<?php if ($subscribe_form): ?>
						<div class="footer-col__form subscribe-form">
							<?php echo do_shortcode($subscribe_form); ?>
						</div>
					<?php endif; ?>

					<?php if ($subscribe_note): ?>
						<small class="footer-col__note text-small descr">
							<?php echo wp_kses_post($subscribe_note); ?>
						</small>
					<?php endif; ?>
				</div>

			</div>

			<!-- BOTTOM: копирайт + ссылки -->
			<div class="footer__bottom">
				<?php if ($copy || $company): ?>
					<div class="footer__copy">
						&copy; <?php echo esc_html($company) . ', ' . date('Y') . '. ' . esc_html($copy); ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($links)): ?>
					<div class="footer__links">
						<?php foreach ($links as $item):
							$link = $item['footer_links_link'] ?? [];
							if (empty($link['url']))
								continue;
							?>
							<a class="footer__link link" href="<?php echo esc_url($link['url']); ?>" <?php if (!empty($link['target'])): ?>target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?> 			<?php if (!empty($link['target']) && $link['target'] === '_blank'): ?>rel="noopener noreferrer" <?php endif; ?>>
								<?php echo esc_html($link['title'] ?? ''); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</footer>
<?php endif; ?>